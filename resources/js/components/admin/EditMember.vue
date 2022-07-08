<template>

    <div class="card w-75 mx-auto py-4">
        <div class="container ">
            <button class="icon-right" @click="this.toggleEdit" data-dismiss="modal">
                <font-awesome-icon icon="fa-solid fa-xmark"/>
            </button>
            <form v-if="this.$props.member"
                  class="editForm"
                  name="form"
                  @submit.prevent=""
                  method="post"
                  enctype="multipart/form-data">

                <p><span class="required">*</span> - Required</p>
                <div class="form-group">
                    <label for="FirstName">First name <span
                        class="minLabel">(Only letters and '`- symbols allowed)</span><span
                        class="required">*</span>:</label>
                    <input type="text"
                           class="form-control"
                           id="FirstName"
                           name="data[firstName]"
                           placeholder="First name..."
                           pattern="^[.\D]{1,30}$"
                           maxlength="30" required
                           @keydown.capture="noDigits($event)"
                           v-model="this.$props.member.firstName">
                    <span class="error" v-if="errors.firstName">
                            {{ errors.firstName[0] }}
                         </span>
                </div>
                <div class="form-group">
                    <label for="LastName">Last name <span class="minLabel">
                        (Only letters and '`- symbols allowed)</span><span class="required">*</span>:
                    </label>
                    <input type="text"
                           class="form-control"
                           id="LastName"
                           name="data[lastName]"
                           placeholder="Last name..."
                           pattern="^[.\D]{1,30}$"
                           maxlength="30" required
                           @keydown.capture="noDigits($event)"
                           v-model="member.lastName">
                    <span class="error" v-if="errors.lastName">
                            {{ errors.lastName[0] }}
                        </span>
                </div>


                <div class="form-group">
                    <label for="BirthDate">Birth Date<span class="required">*</span>:</label>
                    <input type="date"
                           class="form-control"
                           id="BirthDate"
                           name="data[birthDate]"
                           min="1900-01-01"
                           max="2005-01-01"
                           required
                           v-model="member.birthDate">
                    <span class="error" v-if="errors.birthDate">
                            {{ errors.birthDate[0] }}
                        </span>
                </div>
                <div class="form-group">
                    <label for="Country">Country<span class="required">*</span>:</label>
                    <select class="form-control"
                            id="Country"
                            name="data[country]"
                            required
                            v-model="member.country">
                        <option selected disabled="disabled" value="null">Choose Country</option>
                        <option v-for="country in $data.countries" :value="country">{{ country }}</option>
                    </select>
                    <span class="error" v-if="errors.country">
                            {{ errors.country[0] }}
                        </span>
                </div>
                <div class="form-group">
                    <label for="Subject">Report subject<span class="required">*</span>:</label>
                    <input type="text"
                           class="form-control"
                           id="Subject"
                           name="data[subject]"
                           placeholder="Repost subject..."
                           required
                           v-model="member.subject">
                    <span class="error" v-if="errors.subject">
                            {{ errors.subject[0] }}
                        </span>
                </div>
                <div class="form-group">
                    <label for="Phone">Phone number
                        <span class="minLabel">(in the following format: "+1 (555) 555-5555")</span>
                        <span class="required">*</span>:
                    </label>
                    <input class="form-control"
                           id="Phone"
                           name="data[phone]"
                           minlength="17"
                           placeholder="+1 (555) 555-5555"
                           required type="tel"
                           v-model="member.phone"
                           v-mask="'+# (###) ###-####'">
                    <span class="error" v-if="errors.phone">
                        {{ errors.phone[0] }}
                        </span>
                </div>
                <div class="form-group">
                    <label for="Email">Email<span class="required">*</span>:</label>
                    <input type="email"
                           class="form-control"
                           id="Email"
                           name="data[email]"
                           placeholder="your.email@example.com"
                           required
                           v-model="member.email">
                    <span class="error" v-if="errors.email">
                            {{ errors.email[0] }}
                        </span>
                </div>
                <div class="form-group">
                    <label for="Position">Company:</label>
                    <input type="text"
                           id="Position"
                           name="data[company]"
                           class="form-control"
                           placeholder="Company..."
                           v-model="member.company">
                    <span class="error" v-if="errors.company">
                            {{ errors.company[0] }}
                        </span>
                </div>
                <div class="form-group">
                    <label for="Company">Position:</label>
                    <input type="text"
                           id="Company"
                           name="data[position]"
                           class="form-control"
                           placeholder="Position..."
                           v-model="member.position">
                </div>
                <div class="form-group">
                    <label for="About">About:</label>
                    <textarea class="form-control"
                              id="About" rows="3"
                              name="data[about]"
                              placeholder="About me..."
                              v-model="member.about">
                    </textarea>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                <div class="form-group">
                    <label for="imgLoad">New Image (.png, .jpg, .jpeg - up to 10Mb):</label>
                    <input type="file"
                           class="form-control"
                           id="imgLoad"
                           name="photo"
                           accept=".png, .jpg, .jpeg"
                           @change="uploads">
                    <span class="error" v-if="errors.photo">
                        {{ errors.photo[0] }}
                    </span>
                    <button class="form-control delete-btn">Delete photo</button>
                </div>
            </form>
        </div>
    </div>


</template>

<script>

export default {
    name: "EditMember",
    props: {
        member: '',
        edit: false
    },
    data() {
        return {
            mutableEdit: JSON.parse(this.edit),
            extension: null,
            size: null,
            countries: [],
            errors: [],
            error_exist: false,
            photo_error: false,
            fileSize: 0,
        }
    },
    methods: {
        noDigits: function (event) {
            if ('1234567890'.indexOf(event.key) !== -1) {
                event.preventDefault()
            }
        },
        uploads: function (event) {
            this.member.photo = event.target.files['0'];
            this.getFileInfo();
            this.validateUpload();
        },
        getFileInfo: function () {
            let ext = "Couldn't resolve";
            const parts = this.member.name.split('.')
            if (parts.length > 1) {
                ext = '.' + parts.pop()
            }
            this.extension = ext;
            this.fileSize = (this.member.photo.size / 1048576).toFixed(2);
        },
        // sendData: function () {
        //     axios.post('/send', {
        //         firstName: this.form.firstName,
        //         lastName: this.form.lastName,
        //         birthDate: this.form.birthDate,
        //         country: this.form.country,
        //         subject: this.form.subject,
        //         phone: this.form.phone,
        //         email: this.form.email,
        //     })
        //         .then(
        //             response => {
        //                 console.log(response)
        //                 this.error_exist = false;
        //             }
        //         ).catch(
        //         error => {
        //             if (error.response.status === 422) {
        //                 this.errors = error.response.data.errors || {};
        //                 this.error_exist = true;
        //             } else {
        //                 this.error_exist = false;
        //                 console.log(error)
        //             }
        //
        //         })
        //         .then(() => {
        //             if (this.error_exist) {
        //                 return false;
        //             }
        //             this.persist();
        //             this.countries = [];
        //             this.step++;
        //         })
        // },
        // updateData: function () {
        //     if (this.photo_error) {
        //         return false;
        //     } else if (!this.dataExists()) {
        //         this.deleteStore();
        //         this.step++;
        //         return true;
        //     }
        //
        //     if (this.form.photo
        //         || this.form.about
        //         || this.form.company
        //         || this.form.position) {
        //         let data = new FormData();
        //         let newFileName = this.form.email.split('@')[0];
        //
        //         data.append('newName', newFileName);
        //         let array = ['photo', 'email', 'position', 'company', 'about']
        //         for (let i = 0; i < array.length; i++) {
        //             data.append(array[i], this.form[array[i]]);
        //         }
        //
        //         axios.post('/update', data, {
        //             headers: {
        //                 'Content-Type': 'multipart/form-data'
        //             }
        //         }).then(
        //             response => {
        //                 console.log(response.data);
        //                 this.error_exist = false;
        //             }
        //         ).catch(
        //             error => {
        //                 if (error.response.status === 422) {
        //                     this.errors = error.response.data.errors || {};
        //                     this.error_exist = true;
        //                 } else {
        //                     this.error_exist = false;
        //                     console.log(error)
        //                 }
        //             }
        //         ).then(() => {
        //             if (this.error_exist) {
        //                 return false;
        //             }
        //             this.deleteStore();
        //             this.step++;
        //         });
        //     }
        //
        // },
        fetchCountries() {
            axios.get('https://restcountries.com/v3.1/all')
                .then(res => {
                    res = new Array(...res.data)
                    return res;
                })
                .then(data => {
                        data.sort((a, b) => (a.name.common > b.name.common) ? 1 : -1)
                            .forEach(country => {
                                this.countries.push(country.name.common);
                            })
                    }
                )
        },
        trackChanges() {
            this.$emit('changeStep', {
                step: this.step
            })
        },
        validateUpload() {
            if (this.member.photo && this.member.photo.size > 10485760) {
                this.fileSize = (this.member.photo.size / 1048576).toFixed(2);
                this.photo_error = true;
                return false
            } else {
                this.photo_error = false;
                return true
            }
        },
        toggleEdit() {
            this.mutableEdit = false;
            this.$emit("hideModal", this.mutableEdit);
        }
    },
    beforeMount() {
        this.fetchCountries();

    },
}
</script>

<style scoped>

.delete-btn {

}

.delete-btn:hover {
    background-color: #dee2e6;
}

.icon-right {
    border: none;
    background-color: #ffffff;
    float: right;
}

.icon-right:hover {
    background-color: #dee2e6;
}
</style>
