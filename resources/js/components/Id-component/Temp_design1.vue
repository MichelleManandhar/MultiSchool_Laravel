<template >
    <div class="card1 type" >
        <div class="card front" :style="{backgroundColor : designProperty? designProperty.background_color :templateBgColor  , border : '2px solid' +templatebrdrColor }">
        ">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 171.36 158.16">
                <g id="Layer_2" data-name="Layer 2">
                    <title>Asset 1</title>
                    <g id="Front">
                        <g>
                            <g id="Shape_29" data-name="Shape 29">
                                <path class="cls-1"
                                      d="M85.68,147.47c34.17,0,64.81-14,85.68-36.26V0H0V111.21C20.87,133.43,51.51,147.47,85.68,147.47Z"/>
                            </g>
                            <g id="Shape_30" data-name="Shape 30">
                                <path class="cls-2"
                                      d="M0,112.2V93.31c20.87,22.18,51.51,36.18,85.68,36.18s64.81-14,85.68-36.19V112.2c-22.7,19-52.74,30.58-85.68,30.58S22.7,131.21,0,112.2Z"/>
                            </g>
                            <g id="Shape_31" data-name="Shape 31">
                                <path class="cls-3"
                                      d="M129,141.68a150.82,150.82,0,0,0,23.61-4.94,149,149,0,0,1-58.43,20.18A151.13,151.13,0,0,1,0,138.5V93.87C29.94,128.52,78.13,148.15,129,141.68Z"/>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>

            <div class="school-info">
                <div class="school-logo">
                    <div v-if="isnitutionLogo" >  <img :src="isnitutionLogo ? '/storage/upload/logo/'+ isnitutionLogo : '../../../../public/assets/smartschool.png'" :style="{ height : designProperty? designProperty.logo_size+'px' :templatesizeSchoolLogo+'px', width : designProperty? designProperty.logo_size+'px' :templatesizeSchoolLogo+'px'}"/></div>
                    <div v-else><img src="../../../../public/assets/smartschool.png" :style="{ height : designProperty? designProperty.logo_size+'px' :templatesizeSchoolLogo+'px', width : designProperty? designProperty.logo_size+'px' :templatesizeSchoolLogo+'px'  }">
                    </div>

                     </div>
                <div class="school-details">
                    <div class="school-name">{{insitutionName ? insitutionName : 'ITglance Academy' }}</div>
                    <div class="school-address">{{insitutionAddress ? insitutionAddress : 'Tripureshor, Kathmandu' }}</div>
                </div>
            </div>
            <div class="profile-img" :style="{borderRadius :  designProperty? designProperty.image_radius+ '%' :templateimgRadius+ '%' , borderColor : designProperty? designProperty.picture_border_color :templatePicBrdrColor }">
                <div v-if="imageName" >  <img :src="imageName ? '/storage/upload/'+ imageName : 'https://randomuser.me/api/portraits/men/32.jpg'"></div>
                <div v-else> <img src  ="https://randomuser.me/api/portraits/men/32.jpg"></div>
            </div>
            <div class="student-info" :style="{ color:   designProperty? designProperty.text_color :templateTextColor }">
                <div class="student-name center">{{fullName? fullName:'test_user'}}</div>
                <div class="student-address">{{value? value.temporary_address : 'Tripureshwor, Kathmadu' }}</div>
                <div class="student-grade">
                    <span>Grade:</span>
                    <span>
                     {{this.$route.params.classname}}
                    </span>
                </div>
                <div class="student-roll">
                    <span>Roll No:</span>
                    <span>{{value?value.roll_no: 13}}</span>
                </div>
                <div class="student-guardian">
                    <span>Guardian's name:</span>
                    <span>{{value?value.parent_name: "parent name"}}</span>
                </div>
                <div class="student-dob">
                    <span>Date of Birth:</span>
                    <span>{{value?value.DOB: "2019-12-23"}}</span>
                </div>
                <div class="student-phone">
                    <span>Phone:</span>
                    <span>{{value?value.mobile_no: "9843617751"}}</span>
                </div>
            </div>
            <div class="card-date">
                <div class="signature">
                    <div v-if="isnitutionLogo" >  <img :src="isnitutionLogo ? '/storage/upload/sign/'+ insitutionSign : 'https://www.acd.ae/wp-content/uploads/2018/09/random-signature-png.png'"></div>
                    <div v-else><img src="https://www.acd.ae/wp-content/uploads/2018/09/random-signature-png.png"></div>

                </div>
                <div class="join-date">
                    <span>Expiry Date:</span>
                    <span>2075-01-01</span>
                </div>
            </div>
        </div>
        <div class="card back" :style="{backgroundColor : designProperty? designProperty.background_color :templateBgColor }">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 171.36 158.16">

                <title>Asset 1</title>
                <g id="Layer_2" data-name="Layer 2">
                    <g id="Front">
                        <g>
                            <g id="Shape_29" data-name="Shape 29">
                                <path class="cls-1"
                                      d="M85.68,147.47c34.17,0,64.81-14,85.68-36.26V0H0V111.21C20.87,133.43,51.51,147.47,85.68,147.47Z"/>
                            </g>
                            <g id="Shape_30" data-name="Shape 30">
                                <path class="cls-2"
                                      d="M0,112.2V93.31c20.87,22.18,51.51,36.18,85.68,36.18s64.81-14,85.68-36.19V112.2c-22.7,19-52.74,30.58-85.68,30.58S22.7,131.21,0,112.2Z"/>
                            </g>
                            <g id="Shape_31" data-name="Shape 31">
                                <path class="cls-3"
                                      d="M129,141.68a150.82,150.82,0,0,0,23.61-4.94,149,149,0,0,1-58.43,20.18A151.13,151.13,0,0,1,0,138.5V93.87C29.94,128.52,78.13,148.15,129,141.68Z"/>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>

            <div class="qr-code" :style="{ height : designProperty? designProperty.qr_code_size+'px' :templatesizeQR+'px', width : designProperty? designProperty.qr_code_size+'px' :templatesizeQR+'px'  }">
                <div class="qrcode" :style="{ height : designProperty? designProperty.qr_code_size+'px' :templatesizeQR+'px', width : designProperty? designProperty.qr_code_size+'px' :templatesizeQR+'px'  }">
                    <qr-code :text="qr" ></qr-code>
                </div>
            </div>
            <div class="add-info">
                <div class="school-info" :style="{ color:   designProperty? designProperty.text_color :templateTextColor }">
                    <div class="school-logo">
                        <div v-if="isnitutionLogo" >  <img :src="isnitutionLogo ? '/storage/upload/logo/'+ isnitutionLogo : '../../../../public/assets/smartschool.png'"></div>
                        <div v-else><img src="../../../../public/assets/smartschool.png"></div>

                    </div>
                    <div class="school-details">
                        <div class="school-name">{{insitutionName ? insitutionName : 'ITglance Academy' }}</div>
                        <div class="school-address">{{insitutionAddress ? insitutionAddress : 'Tripureshor, Kathmandu' }}</div>
                    </div>
                </div>
                <div class="lost-info">
                    If found please contact
                    <div class="phone-number">981234566</div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import VueQRCodeComponent from 'vue-qrcode-component';
    import Front from '../../../../public/assets/front1.svg';
    export default {
        name: "template1",
        components: {
            'qr-code': VueQRCodeComponent,
            Front
        },
        props : {
            value : '',
            designProperty : '',
            className : ''
        },

        data(){
            return{
                templateBgColor: this.bgcolor,
                templateTextColor: this.txtcolor,
                templatePicBrdrColor: this.pcbrdrcolor,
                templatebrdrColor: this.brdrcolor,
                templateimgRadius: this.brdrcolor,
                templatesizeQR: this.brdrcolor,
                templatesizeSchoolLogo: this.sizeSchoollogo,
                imageName  : '',
                barcodeValue: '',
                insitutionName  : null,
                insitutionAddress  : '',
                isnitutionLogo : null,
                insitutionSign : '',
                fullName : '',
                mname : '',
                qr:''
            }
        },
        created(){
            eventBus.$on('background-color',this.changeBgColor);
            eventBus.$on('text-color',this.changeTextColor);
            eventBus.$on('picBrdr-color',this.changePicBrdrColor);
            eventBus.$on('brdr-color',this.changebrdrColor);
            eventBus.$on('img-radius',this.changeimgRadius);
            eventBus.$on('size-QR',this.changesizeQR);
            eventBus.$on('size-schoolLogo',this.changesizeSchoolLogo);
            if(this.value){this.imageName = this.value.image_name}
            if(this.value){this.mname = this.value.mname ===null ?  " ": this.value.mname}
            if(this.value){this.fullName = this.value.fname +  " " +this.mname + " "+ this.value.lname}
            if(this.value){this.qr= "Fullname :" + this.fullName +"\n"+ "Contact :" + this.value.mobile_no +"\n"+ "DOB:" + this.value.DOB }

            this.getSchoolnformation();
        },
        methods:{
            getSchoolnformation(){
                axios.get('/school/data').then(data =>(
                    data.data.map(info =>{
                        this.insitutionName = info.institute_name;
                        this.insitutionAddress = info.address;
                        this.isnitutionLogo = info.school_logo;
                        this.insitutionSign = info.signature;

                    })
                ));
            },
            changeBgColor(color){
                this.templateBgColor = color.bgColor;
            },
            changeTextColor(color){
                this.templateTextColor = color.txtcolor;
            },
            changePicBrdrColor(color){
                this.templatePicBrdrColor = color.pcbrdrcolor;
            },
            changebrdrColor(color){
                this.templatebrdrColor = color.brdrcolor;
            },
            changeimgRadius(size){
                this.templateimgRadius = size.imgradius;
            },
            changesizeQR(size){
                this.templatesizeQR = size.sizeQR;
            },
            changesizeSchoolLogo(size){
                this.templatesizeSchoolLogo = size.sizeSchoollogo;
            },

        },

    }
</script>

<style scoped>
    .card {
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
    }
</style>
