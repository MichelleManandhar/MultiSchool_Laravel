<template>
  <div class="top-nav">
    <div class="bread-crumb" v-if="className!==''">
      <span>{{className}}</span>
      <span>{{sectionName}}</span>
      <span>{{tabName}}</span>
    </div>
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
      </b-dropdown>

      <b-dropdown size="lg" variant="link" toggle-class="text-decoration-none" no-caret>
        <template slot="button-content">
          <div class="notification-area">
            <i class="fa fa-plus"></i>
          </div>
        </template>
        <b-dropdown-item href="#" @click="show('subjectModal')">
          <i class="fas fa-users"></i>
          Add Subject
        </b-dropdown-item>
        <b-dropdown-item href="#" @click="show('teacherModal')">
          <i class="fas fa-chalkboard-teacher"></i>
          Add Teacher
        </b-dropdown-item>
        <b-dropdown-item href="#" @click="show('examModal')">
          <i class="fas fa-book"></i>
          Add Exam
        </b-dropdown-item>
        <b-dropdown-item href="#" @click="show('idModal')">
          <i class="fas fa-id-card"></i>
          Add Id Template
        </b-dropdown-item>
        <b-dropdown-item href="#" @click="show('feeModal')">
          <i class="fas fa-id-card"></i>
          Add Fee Category
        </b-dropdown-item>
          <b-dropdown-item href="#" @click="show('sponsorModal')">
         <i class="fas fa-hands-helping"></i>
          Add Sponsor
        </b-dropdown-item>
      </b-dropdown>

   
    </div>
    <subject-modal />
    <exam-modal />
    <teacher-modal />
    <id-modal/>
    <fee-modal />
     <sponsor />
  </div>
</template>

<script>
import ExamModal from "./modals/ExamModal";
import TeacherModal from "./modals/TeacherModal";
import SubjectModal from "./modals/SubjectModal";
import IdModal from "./modals/IdModal";
import FeeModal from "./modals/FeeModal";
import SponsorModal from "./modals/SponsorModal";

export default {
  data() {
    return {
      classId: 0,
      sectionId: 0,
      showSettingDropDown: false,
      className: this.$route.params.classname,
      sectionName: this.$route.params.sectionname,
      tabName: "Student"
    };
  },
  created() {
    eventBus.$on("breadCrumbChange", this.breadCrumbChangeSection);
    eventBus.$on("breadCrumbTabChange", this.breadCrumbChangeTab);
  },
  methods: {
    show(modalName) {
      this.$modal.show(modalName);
    },
    breadCrumbChangeSection(data) {
      this.className = data.className;
      this.sectionName = data.sectionName;
    },
    breadCrumbChangeTab(data) {
      this.tabName = data.tabName;
    },
    logout() {
      localStorage.removeItem("default_auth_token");
      this.$router.push("sign");
      this.$noty.success("Logged out successfully");
      this.$session.destroy();
    }
  },
  components: {
    "exam-modal": ExamModal,
    "teacher-modal": TeacherModal,
    "subject-modal": SubjectModal,
    "id-modal": IdModal,
      "fee-modal": FeeModal,
    "sponsor":SponsorModal

  },
  props: {
   
  },

  mounted() {

  }
};
</script>

<style>
.top-nav {
  padding: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;

}
.bread-crumb {
  font-size: 3vh;
}
.image-area-nav {
  height: 50px;
  width: 50px;
  overflow: hidden;
  border-radius: 50%;
  margin-right: 8px;
}
.profile-area {
  display: flex;
}
.notification-area,
.more-nav {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #ebeeee;
  margin-right: 8px;
}
.profile-area i {
  font-size: 3vh;
  object-fit: cover;
  object-position: center;
  color: black;
}
.bread-crumb > span:nth-child(1):before {
  content: "";
}
.bread-crumb > span::before {
  content: ">";
  margin-right: 8px;
}

.bread-crumb > span:last-child {
  color: blue;
}
.settings {
  text-align: center;
  display: flex;
  position: absolute;
  flex-direction: column;
  padding: 8px;
  z-index: 1;
  top: 40px;
  width: 166px;
  right: 0px;
  background-color: white;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12) !important;
}
.settings div {
  margin: 8px;
}
.settings-item a {
  text-decoration: none;
  color: rgba(0, 0, 0, 0.9);
}
.settings-item {
  display: flex;
  cursor: pointer;
}
.settings-item > i {
  margin-right: 8px;
  width: 20%;
}
</style>

