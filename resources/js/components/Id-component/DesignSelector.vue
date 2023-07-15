<template>
    <div class ="id-designer">
        <form @submit ="submitTemplate" >
            <div class="form-group">
                <label class="col-sm-6 control-label">Background color</label>
                <div class="col-sm-6 ">
                    <input type="color" v-model="bgcolor" value="" class="inp"/>{{bgcolor}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">Font color</label>
                <div class="col-sm-6">
                    <input type="color" v-model="txtcolor" value="" class="inp"/>{{txtcolor}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">Image Border radius</label>
                <div class="col-sm-6">
                    <input type="range"  v-model="imgradius" value="50" name="radius" min="0" max="100">{{imgradius}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label"> Image Border color</label>
                <div class="col-sm-6">
                    <input type="color" v-model="pcbrdrcolor" value="" class="inp"/>{{pcbrdrcolor}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label"> Border color</label>
                <div class="col-sm-6">
                    <input type="color" v-model="brdrcolor" value="" class="inp"/>{{brdrcolor}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label"> Size of QR-Code</label>
                <div class="col-sm-6">
                    <input type="range"  v-model="sizeQR" value="150" name="radius" min="100" max="200">{{sizeQR}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label"> Size of School Logo</label>
                <div class="col-sm-6">
                    <input type="range"  v-model="sizeSchoollogo" value="35" name="radius" min="30" max="40">{{sizeSchoollogo}}
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-6 control-label">Template Name</label>
                <div class="col-sm-6">
                    <input type="text" v-model="templateName" value=""/>
                </div>
            </div>
            <div class="form-group">
                <button value="submit" class="btn-save">Save</button>
            </div>
        </form>
    </div>
</template>
<script>
    import  ColorPicker from './ColorPicker';
    import template1 from "./Temp_design1";
    import template2 from "./Temp_normal";
    import template3 from "./Temp_simple";
    import axios from "axios";
    export default {
        name: "DesignSelector",
        components: {
            'colorpicker' : ColorPicker,
            'app-template-1': template1,
            'app-template-2': template2,
            'app-template-3': template3,
        },
        data() {
            return {
                templateName :'',
                bgcolor :'#ffffff',
                txtcolor: '#000000',
                pcbrdrcolor : '#000000',
                brdrcolor : '#000000',
                imgradius : '50',
                sizeQR : '150',
                sizeSchoollogo : '35',
                selected_template: 'template1',
            };
        },
        created(){
            eventBus.$on('selected-tabs',this.changeSelectedTab);
        },
        methods : {
            submitTemplate: function(e){
                e.preventDefault();
                axios.post('idTemplate/submit/',{
                    templateName : this.templateName,
                    bgcolor :this.bgcolor,
                    pcbrdrcolor :this.pcbrdrcolor,
                    brdrcolor :this.brdrcolor,
                    imgradius :this.imgradius,
                    sizeQR :this.sizeQR,
                    sizeSchoollogo :this.sizeSchoollogo,
                    text_color :this.txtcolor,
                    selected_template :this.selected_template
                    }
                ).then((response) => {
                    this.$noty.success("Saved template successfully");
                }).catch(e => {
                    this.$noty.error("Error while saving template");
                });
            },
            changeSelectedTab(tab){
                this.selected_template = tab.selected_tab
            }
        },
        watch :{
            bgcolor:function(val){
                this.bgcolor = val;
                eventBus.$emit('background-color',{
                    bgColor: this.bgcolor
                })
            },
            txtcolor:function(val){
                this.txtcolor = val;
                eventBus.$emit('text-color',{
                    txtcolor: this.txtcolor
                })
            },
            pcbrdrcolor:function(val){
                this.pcbrdrcolor = val;
                eventBus.$emit('picBrdr-color',{
                    pcbrdrcolor: this.pcbrdrcolor
                })
            },
            brdrcolor:function(val){
                this.brdrcolor = val;
                eventBus.$emit('brdr-color',{
                    brdrcolor: this.brdrcolor
                })
            },
            imgradius:function(val){
                this.imgradius = val;
                eventBus.$emit('img-radius',{
                    imgradius: this.imgradius
                })
            },
            sizeQR:function(val){
                this.sizeQR = val;
                eventBus.$emit('size-QR',{
                    sizeQR: this.sizeQR
                })
            },
            sizeSchoollogo:function(val){
                this.sizeSchoollogo = val;
                eventBus.$emit('size-schoolLogo',{
                    sizeSchoollogo: this.sizeSchoollogo
                })
            }
        }
    }
</script>

<style scoped>
    .id-designer{
        padding: 0;
        top: 0;
        left: 0;
        width: 500px;
        height: 100%;
        font-size: 12px;
        font-family: "Poppins", sans-serif;
        box-shadow: 0 0 6px 0 #0056b3;
        overflow-x: hidden;
        overflow-y: scroll;
    }

    .form-group {
        display: flex;
        flex-direction: row;
        margin-bottom: -10px;
    }
    .sendingProp{
        display: none;
    }
    .control-label {
        text-align: left;
    }
    .inp{
        background-color: #cce5ff;
    }
    input[type=text]{
        border: 1px solid rgb(85, 80, 80);
    }
    .btn-save{
        background-color: rgb(0, 119, 255);
        color: white;
        font-size: 14px;
        width: 60px;
        text-align: center;
        height: 30px;
        border-radius : 15%;
        margin : 0 0 5px 5px;
    }

</style>