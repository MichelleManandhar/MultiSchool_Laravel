<template>
    <modal name="SchoolProfile"  height = 90%  width = 85% >
        <div  class="modal-school">
            <div class="modal-header">
                <div class="header-text">Fill School Profile</div>
            </div>
            <div class="modal-title">Basic Information</div>
            <div class="modal-body">
                <div class="input-grp">
                    <label>Organization Name:</label>
                                <input
                                type="text"
                                class="input-signin"
                                placeholder=" Name of School"
                                v-model="nameSchool"
                                name="name"/>
                </div>
                <div class="input-grp">
                    <label >Email Address:</label>
                    <input type="text"
                            class="input-signin"
                            placeholder="School Email"
                            v-model="emailSchool"
                           name="email"/>
                </div>
                <div class="input-grp">
                    <label >Contact:</label>
                        <input type="number"
                                class="input-signin"
                                placeholder="School Contact No."
                                v-model="contactSchool"
                                name="email"/>
                </div>
                <div class="input-grp">
                    <label >Address:</label>
                    <input type="text"
                           class="input-signin"
                           placeholder="School address"
                           v-model="addressSchool"
                           name="email"/>
                </div></div>
            <div class="modal-title">Detail Information</div>
            <div class="modal-body">
                <div class="input-grp">
                    <label >Academic year :</label>
                    <input
                            type="number"
                            class="input-signin"
                            placeholder=" Acaedemic year"
                            v-model="acaedemicYearSchool"
                            name="name"/>
                </div>
                <div class="input-grp">
                    <label >Established Date :</label>
                    <input
                            type="number"
                            class="input-signin"
                            placeholder=" Established year"
                            v-model="establishDateSchool"
                            name="name"/>
                </div>
                <div class="input-grp">
                    <label > Slogan : </label>
                    <input type="text"
                           class="input-signin"
                           placeholder="School Slogan"
                           v-model="sloganSchool"
                           name="email"/>
                </div>
                <div class="input-grp">
                    <label >Website URL : </label>
                    <input type="text"
                           class="input-signin"
                           placeholder="Website urls"
                           v-model="websiteSchool"
                           name="email"/>
                </div>
            </div>
            <div class="modal-title">Files</div>
            <div class="modal-body">
                <div class="input-grp">
                    <label >Signature(100px * 400px):</label>
                    <input
                            type="file"
                            placeholder=" Name of School"
                            v-on:change="signSchoolChange"
                            name="name"
                            accept=".jpg,.jpeg,.png"
                    />
                </div>
                <div class="input-grp">
                    <label >Organization Logo:</label>
                    <input type="file"
                           placeholder="School Email"
                           v-on:change="logoSchoolChange"
                           name="email"
                           accept=".jpg,.jpeg,.png"
                    />
                </div>
            </div>
            <div class="button-group">
            <button type="button" class="update-button" v-on:click="Update">Update</button>
                <button type="button" class="reset-button" v-on:click="Reset">Reset</button></div>
        </div>
    </modal>
</template>

<script>
import axios from "axios";
    export default {
        name: "SchoolProfile",
        data() {
            return {
                nameSchool : '',
                emailSchool : '',
                contactSchool : '',
                addressSchool : '',
                acaedemicYearSchool : '',
                sloganSchool : '',
                websiteSchool : '',
                signSchool : '',
                signSchoolFile : '',
                signSchoolImg :'',
                logoSchool : '',
                logSchoolImg :'',
                logoSchoolFile : '',
                establishDateSchool : ''
            };
            },
        created(){
            axios.get("/school/data").then(res => res.data.map(details => {
                    this.nameSchool = details.institute_name,
                    this.emailSchool = details.email,
                    this.contactSchool = details.contact,
                    this.addressSchool= details.address,
                    this.acaedemicYearSchool = details.acaedemic_year,
                    this.sloganSchool = details.slogan,
                    this.websiteSchool = details.website_link,
                    this.signSchoolImg = details.signature,
                    this.logoSchoolImg = details.school_logo,
                    this.establishDateSchool = details.establish_date
            }));
        },
        methods:{
            logoSchoolChange(e) {
                let files = e.target.files ;
                if (!files.length)
                    return;
                this.logoSchoolFile = files[0]
                this.logoSchoolImage(files[0]);
            },
            logoSchoolImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.logoSchool = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            signSchoolChange(e) {
                let files = e.target.files ;
                if (!files.length)
                    return;
                this.signSchoolFile = files[0];
                this.signSchoolImage(files[0]);
            },
            signSchoolImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.signSchool = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            Reset(){
                
            },
            Update(){
                axios
                    .post("/school/store", this.getData())
                    .then(res => {
                        this.$noty.success(res.data.message);
                    })
                    .catch(err => {
                        this.$noty.error("Error in saving school profile");
 
                    });
            },
            getData(){
                let data = new FormData();
                data.append('uid',this.uid);
                data.append('nameSchool',this.nameSchool);
                data.append('emailSchool',this.emailSchool);
                data.append('contactSchool', this.contactSchool);
                data.append('addressSchool', this.addressSchool);
                data.append('acaedemicYearSchool', this.acaedemicYearSchool);
                data.append('sloganSchool', this.sloganSchool);
                data.append('websiteSchool', this.websiteSchool);
                data.append('signSchool', this.signSchoolFile);
                data.append('logoSchool', this.logoSchoolFile);
                data.append('establishDateSchool', this.establishDateSchool);
                return data;
            }
        }
    }
</script>

<style scoped>
    .modal-school{
        height: calc(100% - 0px);
        padding: 5px;
        overflow-y: auto;
    }
    .content {
        color: black;
        width: 60%;
        height: 60%;
        background: white;
        z-index:10;
    }

    .modal-body{
        font-size: 13px;
        display: flex;
        padding: 15px;
        justify-content: space-between;
        flex-wrap: wrap;
        flex-direction: row;
    }
    .modal-header {
        font-size: 20px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
    }
    .modal-title{
        margin :2px;
        width: 100%;
        height: 30px;
        border: 1px solid #eeeeee;
    }
    .input-grp{
        height:  80px;
        width: 550px;   
    }

    .input-grp > label{
        width : 150px;
    }
    .input-grp> .input-signin {
        height: 45px;
        width: 350px;
        border: 1px solid #b4b4b4;
        border-radius: 3px;
        color: black;
        font-size: 15px;
        padding-left: 10px;
        outline: none;
    }
    .update-button{
        height  : 40px;
        width : 90px;
        background-color: #007BFF;
        color : #fff;
        text-align: center;
        font-size : 14px;
        border-radius: 25px;
        margin : 10px
    }
     .button-group{
         float: right;
     }
    .reset-button{
        height  : 40px;
        width : 90px;
        background-color: #E45545;
        color : #fff;
        text-align: center;
        font-size : 14px;
        border-radius: 25px;
    }
    .displayed-img-logo{
        height: 100px;
        width: 100px;
        object-fit: contain;
        object-position: center;
    }
</style>