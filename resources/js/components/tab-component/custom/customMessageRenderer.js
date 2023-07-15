import Vue from "vue";

export default Vue.extend({
    template: `
        <span style="height:100%;width:100%">
            <input style="height:100%;width:100%" class="action" type="file" name="image" value=""   @change="fileUpload" accept="image/gif, image/jpeg, image/png">
        </span>
    `,
    data: function () {
        return {
            image: {}
        };
    },
    beforeMount() {
    },
    mounted() {
        XMLHttpRequest
    },
    methods: {
        fileUpload(event){
            this.image = event.target.files[0];
            eventBus.$emit('brdr-image_upload',{
                image: this.image
            });
            if (this.params.data.id != null) {
                axios
                    .post(
                        "student/edit/" +
                        this.params.data.class_id +
                        "/" +
                        this.params.data.section_id +
                        "/" +
                        this.params.data.id,
                        this.data()
                    ).then(data => {
                    eventBus.$emit('update-student');
                    this.$noty.success("Student updated successfully");
                })
                    .catch(e => {
                        this.$noty.error("Error while updating student");
                    });
            }else{
                eventBus.$emit('imageupload',{
                    image: this.image
                });
            }
        },
        data() {
            let formData = new FormData();
            for (let property in this.params.data) {
                if (Array.isArray(this.params.data[property])) {
                    for (let i = 0; i < this.params.data[property].length; i++) {
                        formData.append(`${property}[]`, this.params.data[property][i]);
                    }
                } else {
                    formData.append(property,(this.params.data[property]!=null)?this.params.data[property]:'');
                }
            }
            formData.append('image', this.image);
            return formData;
        }
    }
});