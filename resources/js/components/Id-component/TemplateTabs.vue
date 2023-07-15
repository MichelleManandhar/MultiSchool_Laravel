<template>
    <div>
        <div class="tabs">
            <div class="header-item">
                <div v-for="tab in templateTabs" :class="{ 'isSelected': tab.isActive } "  id="listTabs" >
                    <a :href="tab.href" @click="selectTab(tab)">{{ tab.name }}</a>
                </div>
            </div>
        </div>
        <div class="tabs-details">
            <slot class="id-details"></slot>
        </div>
    </div>
</template>

<script>
    import tab from './IdTabs';
    export default {
        name: "templateTabs",
        components: {
            'tab' : tab
        },
        data() {
            return {
                templateTabs: [] ,
                selected_tab :  'template1'
            };
        },
        created() {

            this.templateTabs = this.$children;
            eventBus.$emit('selected-tabs',{
                selected_tab : this.selected_tab
            })
        },
        methods: {
            selectTab(selectedTab) {
                this.templateTabs.forEach(tab => {
                    if(tab === selectedTab){
                        tab.isActive = true;
                        eventBus.$emit('selected-tabs',{
                            selected_tab : tab.name
                        })
                    }
                    else{tab.isActive = false;}
                });

            }
        }
    }

</script>

<style scoped>
    .header-item {
        height: 50px;
        width: 250px;
        font-size: 12px;
        display: flex;
        text-align: center;
        background-color: #fff;
        margin-right: 20px;
    }

    .header-item #listTabs{
        height: 30px;
        width: 50%;
        padding: 8px;
    }
    .tabs {
        display: flex;
        flex-direction: column;
        float: right;
        margin-right: 10px;
    }
    .tab-headers {
        display: flex;
        z-index: 0;
    }

    .tabs-details{
        height: 90%;
        width: 100%;
    }
    .id-details{
        padding: 10px;
    }

    .isSelected{
        background-color: #4bb1b1;
    }
</style>