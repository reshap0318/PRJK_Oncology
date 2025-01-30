<?php

namespace App\Services;

use App\Http\Responses\{
    Success, Error
};
use Illuminate\Support\Facades\{
    DB, Log
};
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\JsonResponse;
use Exception;

class BaseService
{
    protected $mainRepository;
    protected $isSuccess        = false;
    protected $data             = null;
    protected $code             = 500;
    protected $message          = null;

    public function transaction($function_some){
        DB::beginTransaction();
        try {
            $this->isSuccess      = true;
            $this->data           = $function_some();
            $this->code           = 200;
            DB::commit();
        }catch (HttpException $ex){
            DB::rollBack();
            $this->isSuccess      = false;
            $this->message        = $ex->getMessage();
            $this->code           = $ex->getStatusCode();
            Log::error($ex);
        } catch (Exception $e){
            DB::rollBack();
            $this->isSuccess      = false;
            $this->code           = 500;
            $this->message        = $e->getMessage();
            Log::error($e);
        }
        return $this;
    }

    public function commandResult(){
        return [
            $this->isSuccess,
            $this->message,
            $this->data,
            $this->code
        ];
    }

    public function responseResult(): JsonResponse
    {
        if ($this->isSuccess) {
            if($this->message && $this->data) return Success::defaultSuccessExtraMessageAndData($this->message, $this->data);
            if($this->message) return Success::defaultSuccessExtraMessage($this->message);
            if($this->data) return Success::defaultSuccessWithData($this->data);
            return Success::defaultSuccess();
        }else{
            if($this->code == 404) return Error::defaultPageNotFoundError();
            return Error::defaultErrorExtraCodeAndMessage($this->code, $this->message);
        }
    }

    public function create($data)
    {
        $res = $this->mainRepository->create($data);
        return $res;
    }

    public function update($id, $data)
    {
        $res = $this->mainRepository->update($id, $data);
        return $res;
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }
}