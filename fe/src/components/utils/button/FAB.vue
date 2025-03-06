<template>
    <a href="javascript:void(0)" class="act-btn"> + </a>
</template>

<script setup lang="ts"></script>

<style>
.act-btn {
    background: #7239ea;
    display: block;
    width: 50px;
    height: 50px;
    line-height: 43px;
    text-align: center;
    color: white;
    font-size: 40px;
    font-weight: bold;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    text-decoration: none;
    transition: ease all 0.3s;
    position: fixed;
    right: 30px;
    bottom: 30px;
}

.act-btn:hover {
    color: white;
}

.act-btn:active {
    color: white;
}
</style>
