<template>
    <modal name="idModal"  width="85%" height="85%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-text">Design the template</div></div>

            <div class="tabs">
                <templatetabs>
                          <tab  name="template1" :selected="true">
                        <div class="tabs-description">
                            <DesignSelector/>
                            <template1 name="template1" class="templates"/>
                        </div></tab>
                    <tab  name="template2" >
                    <div class="tabs-description">
                        <DesignSelector/>
                        <template2 name="template2" class="templates"/>
                    </div></tab>
                    <tab  name="template3" >
                        <div class="tabs-description">
                            <DesignSelector/>
                            <template3 name="template3" class="templates"/>
                        </div></tab>
                </templatetabs>
            </div>
        </div>
    </modal>
</template>

<script>
    import template1 from "../Id-component/Temp_design1";
    import template2 from "../Id-component/Temp_normal";
    import template3 from "../Id-component/Temp_simple";
    import templatetabs from "../Id-component/TemplateTabs";
    import tab from "../Id-component/IdTabs";
    import DesignSelector from "../Id-component/DesignSelector";
    export default {
        name: "IdModal",
        components: {
            "template1" : template1,
            "template2" : template2,
            "template3" : template3,
            "templatetabs" : templatetabs,
            "tab" : tab,
            "DesignSelector" : DesignSelector,
        },

        data() {
            return {
                templatetabs: [],
                isActive: false
            };
        },


    };
</script>

<style scoped lang = "scss">

    .modal-content {
        height:calc(100% - 0px);
        overflow-y: auto;
        height: 100%;
        width: 100%;
        padding: 10px;
    }
    .modal-header {
        font-size: 20px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
    }
    button {
        background-color: rgb(0, 136, 199);
        color: white;
        padding: 10px;
        box-sizing: border-box;
    }
    .header-text{
        height: 40px;
    }
    .tabs-description{
        margin-left: 0;
        width:100%;
        height: 100%;
        display : flex;
        flex-direction: row;
    }
    .designContent{
        width: 40%;
    }
    .templates{
        margin: 0 1% 1% 10%;
        width: 60%;
        height: 600px;
        overflow-y: scroll;
    }
</style>