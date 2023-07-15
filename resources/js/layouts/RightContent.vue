<template>
    <div class="right-panel">
        <app-top-nav></app-top-nav>
        <app-tabs></app-tabs>
    </div>
</template>

<script>
    import TopNav from '../components/TopNav'
    import Tabs from '../components/Tabs'

    export default {
        name: "Topbar",
        components: {
            'app-top-nav': TopNav,
            'app-tabs': Tabs
        },

    }
</script>

<style>
    .right-panel {
        flex: 1;
        position:relative;
    }
    .btn{
        border: 1px solid rgba(0,0,0,0.3);
        padding: 8px;
        color: white;
        border-radius: 8px;
    }
    .btn-delete{
        background: #ff6931;
    }
    .btn-add-row{
        background: #1717ff;
    }
    .button-area{
        display: flex;
        justify-content: space-between;
        padding: 8px 15px;
    }
</style>