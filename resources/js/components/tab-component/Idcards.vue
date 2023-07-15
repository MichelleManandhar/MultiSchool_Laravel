<template>
    <div class="dashbody" v-show="this.isActiveComputed" >
        <div v-for="tabs in templateData" v-model="active_tab" :class="{ 'isSelectedTemplate': tabs.isActive } " :key="tabs.id" class="templateTabs">
                        <button class="indTemplate"    @click="selectTab(tabs)"> {{tabs.template_name}}</button>
                </div>


        <div class="button-area">
            <button class=" btn-print" @click="printAll()">Print All</button>
        </div>
        <div  class="studentId">
            <div v-for="value in studentData" class="indIds"  >
                <div ref="ids" :id=value.id>
                <div v-if = "selectedDesign === 'template1' "><template1   :value =value :designProperty=selectedTemplate  class="templateBlur" ></template1></div>
                <div v-else-if = "selectedDesign === 'template2' "><template2  :value =value :designProperty=selectedTemplate  class="templateBlur"  ></template2></div>
                <div v-else-if = "selectedDesign === 'template3' "><template3   :value =value :designProperty=selectedTemplate  class="templateBlur"  ></template3></div>
                <div v-else ><template3   :value =value  class="templateBlur"  ></template3></div>
                </div>
                    <button type="button" class="btn-individual-print" @click = "printIndividual(value.id , )">Print</button>

            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import Printd from 'printd';
    import template1 from "../Id-component/Temp_design1";
    import template2 from "../Id-component/Temp_normal";
    import template3 from "../Id-component/Temp_simple";
    export default {
        name: "Idcards",
        props: {
            name: { required: true },
            isselected: { default: false },
            classId: { required: true },
            sectionId: { required: true }
        },
        components: {
            "template1" : template1,
            "template2" : template2,
            "template3" : template3,
        },
        data() {
            return {
                isActive: false,
                studentData: null,
                templateData : null,
                selectedTemplate : null,
                selectedDesign : null,
                active_tab : 1,
                cssText: `
               .card {
                    -webkit-print-color-adjust: exact !important;
                    font-size: .8rem;
                    height: 450px;
                    width: calc(450px * 2.125 / 3.375);
                    border: 1px solid rgba(0, 0, 0, 0.2);
                    border-radius: 10px;
                    padding: 10px;
                    box-sizing: border-box;
                    margin: 5px;
                    position: relative;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-between;
                    position: relative;
    }

    .card > div {
        z-index: 1;
        position: relative;
    }

    svg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: auto;
    }

    .card1 svg {
        top: -20%;
    }

    .school-info {
        display: flex;
        align-items: center;
    }

    .school-logo {
        margin: 10px 0;
        padding: 10px;
        box-sizing: border-box;
        height: 50px;
        width: 50px;
        border-radius: 50%;
    }

    .school-name {
        color: orange;
        font-weight: bolder;
        font-size: 1rem;
    }

    .school-address {
        color: white;
        font-size: .8rem;
    }

    .profile-img {
        height: 100px;
        width: 100px;
        border-radius: 50px;
        overflow: hidden;
        margin: 10px 0;
        border: 3px solid orange;
        box-shadow: 0 0 8px 3px rgba(0, 0, 0, 0.12)
    }

    img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
    }

    .student-info {
        flex: 3;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 25px 0;
        box-sizing: border-box;
        width: 95%;
    }

    .center {
        text-align: center;
    }

    .student-info > div {
        width: 100%;
        justify-content: center;
    }

    .card-date {
        width: 95%;
    }

    .signature {
        height: 50px;
    }

    .signature > img {
        height: 100%;
        width: 100%;
        object-fit: contain;
    }

    .student-info > div, .card-date > div {
        display: flex;
    }

    .student-info > div > span, .card-date > div > span {
        flex: 1;
        padding: 0 5px;
        box-sizing: border-box;
    }

    .student-grade {
        margin-top: 10px;
    }

    div > span:nth-child(1) {
        text-align: right
    }

    div > span:nth-child(2) {
        text-align: left
    }

    .student-info > .student-name {
        font-size: 1rem;
        font-weight: bold;
    }

    .lost-info {
        margin: 30px 0;
        text-align: center;
        font-size: 1.2rem;
    }

    .phone-number {
        font-size: 1.4rem;
        color: orange;
    }

    .card1 > .back > svg {
        transform: scale(-1, 1);
    }

    .card2 > .back > svg {
        top: unset;
        bottom: 0;
    }

    .back > .qr-code {
        height: 100px;
        width: 100px;
        overflow: hidden;
        border-radius: 5px;
        overflow: hidden;
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.12);
    }

    .type {
        margin: 5px 0;
        display: flex;
    }

    .back > .pattern-background {
        transform: rotate(45deg);
        left: -29%;
    }

    .card2 .back {
        flex-direction: column-reverse;
    }

    .back .school-address {
        color: rgba(0, 0, 0, 0.9);
    }

    .card3 .school-name {
        color: rgba(0, 0, 0, 0.9);
    }

    .cls-1 {
        fill: #333132;
    }

    .cls-2 {
        fill: #f37021;
        fill-rule: evenodd;
    }

    .cls-3 {
        fill: #faa61a;
    }
     .cls-4{
        fill: #1f2835;
    }

    .cls-5 {
        fill: #ffc20e;
    }

    .cls-6 {
        fill: #f68b1f;
    }`
            };
        },
        computed: {
            href() {
                return "#" + this.name.toLowerCase().replace(/ /g, "-");
            },
            isActiveComputed() {
                return this.isActive;
            }
        },
        created() {
            eventBus.$on('update-student',this.getStudentData);
            this.isActive = this.isselected;
            axios.get("/student/" + this.sectionId).then(result => {
                this.studentData = result.data.data;
            });
            axios.get("/idTemplate/" ).then(result => {
                try{
                this.templateData = result.data[0];
                this.selectedTemplate = result.data[0][0];
                this.selectedDesign = result.data[0][0].template_selected;}
                catch (e) {
                }
            });
            this.d = new Printd();
        },
        watch: {
            sectionId: function() {
                this.getStudentData();
            }
        },
        methods: {
            getStudentData() {
                axios.get("/student/" + this.sectionId).then(result => {
                    this.studentData = result.data.data;
                });
            },
            selectTab(selectedTab) {
                this.templateData.forEach(tab => {
                    if (tab === selectedTab) {
                        this.selectedTemplate =  tab;
                        this.selectedDesign = tab.template_selected;
                        tab.isActive = true;
                    }
                    else {
                        tab.isActive = false;
                    }});
            },
            printAll(){
                this.$refs.ids.map((result)=>
                    {
                        this.d = new Printd();
                        this.d.print( result , [this.cssText])
                    }
                )
            },
            printIndividual(val){
                this.d.print( document.getElementById(val) , [this.cssText])

            }
        }
    };
</script>
<style>
    .dashbody {
        margin: 20px 10px 10px 10px;
        height: 100vh;
        overflow-y: scroll;
    }
    .studentId{
        padding: 0;
        margin: 10px;
        height:calc(100% - 0px);
        overflow-y: auto;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-flow: row wrap;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .indIds{
        padding: 20px;
        border : 1px #DDE7F2 solid;
        height: 100%;
        margin-top: 20px;
        position: relative;
    }
    .templateTabs {
        display: flex;
        flex-direction: column;
        float: right;
        margin-right: 10px;
        padding : 10px;
        color: white;
        background-color: blueviolet;
    }
    .blue{
        color: white;
        background-color: blueviolet;
    }

    .grey{
        background-color: #4bb1b1;
        color: #000;
    }
    .btn-print{
        float: right;
        background-color: aqua;
        border-color: blue;
        width :100px;
        height  : 30px;
    }

    .btn-individual-print{
        z-index: 1;
        display: none;
        width :150px;
        height  : 50px;
        top: 0;
        left: 0;
        background-color: blue;
        border-color: #eeee;
        align-content: center;
        margin: 40% 40%;
        color : white;
        position: absolute;
        border-radius: 10px;
    }
    .templateBlur{
        z-index: 0;
        position : relative;
    }

    .indIds:hover .templateBlur {
        filter: blur(1px);
    }
    .indIds:hover .btn-individual-print {
        display: inline-block;
        transition-duration: 2s;
        transition-timing-function: linear;
        transition-delay: 1s;
    }
</style>
