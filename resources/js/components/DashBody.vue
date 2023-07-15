<template>
  <div>
    <div class="profile-area">
    <b-dropdown size="lg" variant="link" toggle-class="text-decoration-none" no-caret>
      <template slot="button-content">
        <div class="image-area-nav">
          <img
                  src="https://cdn.pixabay.com/photo/2013/02/15/11/54/robert-patrick-81871_960_720.jpg"
                  alt
          />
        </div>
      </template>
      <b-dropdown-item href="#" @click="logout()">Logout</b-dropdown-item>
    </b-dropdown></div>
  <div class="dashbody">
    <div class="dash-cards">
      <div class="cards">
        <i class="fas fa-school logo"></i>
        <div class="card-title"> Setup School Profile</div>
        <div class="card-description"> Fill detail school information </div>
        <button class="card-button" @click="show('SchoolProfile')">Manage</button>
      </div>
      <div class="cards">
        <i class="fas fa-chalkboard logo"></i>
        <div class="card-title"> Manage Classes</div>
        <div class="card-description"> Manage how many classes are in school</div>
        <button class="card-button" @click="show('classModal')">Manage</button>
      </div>
      <div class="cards">
        <i class="fas fa-book-open logo"></i>
        <div class="card-title"> Manage Subjects</div>
        <div class="card-description"> Add subjects</div>
        <button class="card-button" @click="show('subjectModal')">Manage</button>
      </div>
      <div class="cards">
        <i class="fas fa-chalkboard-teacher logo"></i>
        <div class="card-title"> Manage Teacher</div>
        <div class="card-description"> Add teachers </div>
        <button class="card-button" @click="show('teacherModal')">Manage</button>
      </div>
      <div class="cards">
        <i class="fas fa-diagnoses logo"></i>
        <div class="card-title"> Manage Exam</div>
        <div class="card-description"> Add exams</div>
        <button class="card-button" @click="show('examModal')">Manage</button>
      </div>
      <div class="cards">
        <i class="far fa-id-card logo" ></i>
        <div class="card-title"> Manage Id Template</div>
        <div class="card-description"> Add Id Templates</div>
        <button class="card-button" @click="show('idModal')">Manage</button>
      </div>
      <div class="cards">
        <i class="fas fa-money-bill logo"></i>
        <div class="card-title"> Manage Fee Category</div>
        <div class="card-description"> Add fee category </div>
        <button class="card-button" @click="show('feeModal')">Manage</button>
      </div>
       <div class="cards">
        <i class="fas fa-users logo" ></i>
        <div class="card-title"> Manage Sponsor</div>
        <div class="card-description"> Add Sponsor</div>
        <button class="card-button" @click="show('sponsorModal')">Manage</button>
      </div>
    </div>
    <subject-modal />
    <exam-modal />
    <class-modal />
    <teacher-modal />
    <fee-modal />
    <id-modal/>
    <school-profile/>
    <sponsor />
  </div></div>
</template>

<script>
    import ExamModal from "./modals/ExamModal";
    import TeacherModal from "./modals/TeacherModal";
    import SubjectModal from "./modals/SubjectModal";
    import SponsorModal from "./modals/SponsorModal";
    import IdModal from "./modals/IdModal";
    import FeeModal from "./modals/FeeModal";
    import ClassModal from "./modals/ClassModal";
    import SchoolProfile from "./modals/SchoolProfile";
    import TopNav from "./TopNav";
export default {
  name: "DashBody",
    components: {
        "exam-modal": ExamModal,
        "teacher-modal": TeacherModal,
        "subject-modal": SubjectModal,
        "id-modal": IdModal,
        "school-profile": SchoolProfile,
        "class-modal": ClassModal,
        "fee-modal": FeeModal,
        "top-nav" : TopNav,
        "sponsor":SponsorModal,
    },
    methods: {
        show(modalName) {
            this.$modal.show(modalName);
        },
        logout() {
            localStorage.removeItem("default_auth_token");
            this.$router.push("/sign");
            this.$noty.success("Logged out successfully");
            this.$session.destroy();
        }
    }
};
</script>

<style scoped>
.dashbody {
  text-align: center;
  font-family: "Poppins", sans-serif;
  margin: 10px 10px 10px 10px;
  width: 98%;
  height: 98%;
  box-shadow: 2px 2px 2px 2px #abdde5;
  padding: 3% 5% ;
}
.image-area-nav {
  height: 50px;
  width: 50px;
  overflow: hidden;
  border-radius: 50%;
  margin-right: 8px;
}
.profile-area{
  float: right;
}
.dash-cards{
  display: flex ;
  flex-direction : row;
  flex-wrap : wrap;
  justify-content : space-around;
}

.dash-cards > .cards{
  height : 270px;
  width : 250px;
  margin : 3%;
  border: 1px solid rgba(5, 4, 97, 0.12);
  color : #2792C6;
  text-align: center;
  padding-top: 3%;
}
.cards > .logo{
    font-size: 50px;
    margin: 10px;
}

.card-title{
  font-size: 15px;
  font-weight : bold;
}
.card-description{
  color : #2792C6;
  text-align: center;
  font-size: 10px;
  margin: 10px;
}
  .card-button {
    color: #fff;
    font-size : 13px;
    background-color : #2792C6;
    width : 100px;
    height : 30px;
    border-radius : 25px;
  }
</style>