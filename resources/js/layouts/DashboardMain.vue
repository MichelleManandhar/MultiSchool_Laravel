<template>
    <div class="main-layout">
    <Sidebar/>
        <router-view></router-view>
    </div>
</template>

<script>
    import Sidebar from '../components/Sidebar';
    import RightContent from './RightContent';
    import DashBody from '../components/DashBody';
    export default {
        name: "DashboardMain",
        components :{ Sidebar , RightContent, DashBody},

    }
</script>

<style >
    img{
        height:100%;
        width:100%;
        object-position: center;
        object-fit: cover;
    }
    .main-layout{
        position: fixed;
        height: 100vh;
        min-width: 100%;
        top: 0;
        left: 0;
        display: flex;
    }
    *{
        font-family:poppins;
    }
    ::-webkit-scrollbar {
        width: 5px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        width: 5px;
        background: #075a82;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: skyblue;
    }
</style>