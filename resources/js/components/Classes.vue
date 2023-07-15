<template>
    <div class="classes" :class="{ 'selected' : isOpen }">
        <app-section-modal v-if="isModalActive" :classid = "singleClass.id" :classname = "singleClass.name" @closemodal="modalActive = false"></app-section-modal>
        <span class="main-title" @click="openClass">{{singleClass.name}} <span id="class-section-add" style="display: none" @click.stop="openSectionAddDialog">+</span></span>
        <div v-for="section in singleClass.section" class="class-info" v-if="isSelected" @click="changeBreadCrumb(singleClass.name,section.name)">
            <router-link :to="{name:'classTab',params :{ classid:singleClass.id, classname : singleClass.name,  sectionid:section.id , sectionname: section.name }}" style="display:flex"
                         >
                <div class="section-title" @click="emitSection(singleClass.id,section.id)">{{section.name}}</div>
            </router-link>
        </div>
    </div>
</template>

<script>
    import Teacher from './tab-component/Teacher'
    import Attendance from './tab-component/Attendance'
    import Subject from './tab-component/Subject'
    import Student from './tab-component/Student'
    import Examination from './tab-component/Examination'
    import SectionModal from './modals/SectionModal'


    export default {
        props: ['singleClass'],
        name: 'Classes',
        components: {
            'app-teacher': Teacher,
            'app-attendance': Attendance,
            'app-subject': Subject,
            'app-student': Student,
            'app-examination': Examination,
            'app-section-modal': SectionModal
        },
        data() {
            return {
                isOpen: false,
                modalActive: false
            }
        },
        created() {
            eventBus.$on('anotherOpened', (id) => {

                this.closeClass(id);
            });
        },
        methods: {
            openClass() {
                this.isOpen = !this.isOpen;
                eventBus.$emit('anotherOpened', this.singleClass.id);
            },
            closeClass(id) {
                if (id !== this.singleClass.id) {
                    this.isOpen = false;
                }
            },
            emitSection(classId, sectionId , sectionName , className) {
                eventBus.$emit('sectionChange', {
                    classId: this.singleClass.id,
                    sectionId: sectionId,
                    className : this.singleClass.name,
                })
            },
            emitTab(sectionId, tabName) {
                eventBus.$emit('tabChange', {
                    classId: this.singleClass.id,
                    sectionId: sectionId,

                    className : this.singleClass.name,
                    sectionName : this.section.name,
                    tabName: tabName
                });
            },
            changeBreadCrumb(className,sectionName){
                eventBus.$emit('breadCrumbChange',{
                    className:className,
                    sectionName:sectionName,
                })
            },
            openSectionAddDialog(event){
                this.modalActive = true;
            }
        },
        computed: {
            isSelected() {
                return this.isOpen;
            },
            href() {
                return '#' + this.singleClass.name.toLowerCase().replace(/ /g, '-');
            },
            isModalActive(){
                return this.modalActive
            }
        }
    }
</script>

<style>
    .classes {
        font-size: 12px;
        width: 100%;
        align-items: flex-end;
        transition: .3s ease-in;
        min-height: 3vh;
    }

    .classes, .class-info, .section-body {
        display: flex;
        flex-direction: column;
    }

    .classes:hover {
        background-color: #0971a5;
        border: 1px solid #49a1cc;
        border-right: 5px;
    }

    .selected {
        background-color: #0971a5;
        border: 1px solid #49a1cc;
        border-right: 5px;
    }

    .main-title {
        font-size: 14px;
        cursor: pointer;
        width: 100%;
        padding: 10px 0px 10px 50px;
    }

    .selected > .main-title {
        display: flex;
        justify-content: space-between;
        border-left: 5px solid rgba(0, 0, 0, 0.3);
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        padding: 10px 20px 10px 35px;
    }
    .selected #class-section-add {
        display:flex!important;
    }

    .selected > .class-info {
        padding: 10px 0 10px 26%;
    }

    .class-info {
        width: 100%;
        padding: 0 0 10px 26%;
    }
  
    .section-title {
        font-weight: bold;
        padding: 0 0 10px 0;        
    }

    .section-body {
        padding-left: 10px;
    }

    .section-body > a {
        padding-bottom: 10px;
        text-decoration: none;
        color: white;
    }
  
    .section-body > a:last-child > span {
        padding: 0;
    }

</style>