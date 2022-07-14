<template>

    <div class=" background-modal d-flex justify-content-center">
        <div class="content-modal card w-75 my-4 py-2 ">
            <div class="container ">
                <button class="icon-right"
                        @click="toggleEdit('exit Edit Page', 'exit')">
                    <font-awesome-icon icon="fa-solid fa-xmark"/>
                </button>

                <confirm-modal v-if="confirm === true"
                               :message="this.message"
                               :prop="this.prop"
                               @cancelModal="trackModal"
                               @confirmModal="trackModal"
                ></confirm-modal>

                <form v-if="memberToEdit"
                      class="editForm"
                      name="form"
                      @submit.prevent=""
                      method="post"
                      enctype="multipart/form-data">

                    <p><span class="required">*</span> - Required</p>
                    <div class="d-flex flex-row justify-content-between">
                        <div class="form-group w-50 me-2">
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
                                   v-model="memberToEdit.firstName">
                            <span class="error" v-if="errors.firstName">{{ errors.firstName[0] }}</span>
                        </div>
                        <div class="form-group w-50 ms-2">
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
                                   v-model="memberToEdit.lastName">
                            <span class="error" v-if="errors.lastName">{{ errors.lastName[0] }}</span>
                        </div>
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div class="form-group w-50 me-2">
                            <label for="BirthDate">Birth Date<span class="required">*</span>:</label>
                            <input type="date"
                                   class="form-control"
                                   id="BirthDate"
                                   name="data[birthDate]"
                                   min="1900-01-01"
                                   max="2005-01-01"
                                   required
                                   v-model="memberToEdit.birthDate">
                            <span class="error" v-if="errors.birthDate">{{ errors.birthDate[0] }}</span>
                        </div>
                        <div class="form-group w-50 ms-2">
                            <label for="Country">Country<span class="required">*</span>:</label>
                            <select class="form-control"
                                    id="Country"
                                    name="data[country]"
                                    required
                                    v-model="memberToEdit.country">
                                <option selected disabled="disabled" value="null">Choose Country</option>
                                <option v-for="country in $data.countries" :value="country">{{ country }}</option>
                            </select>
                            <span class="error" v-if="errors.country">{{ errors.country[0] }}</span>
                        </div>
                    </div>

                    <div class="d-flex flex-row justify-content-between align-content-center">
                        <div class="form-group w-50 me-2">
                            <label for="Email">Email<span class="required">*</span>:</label>
                            <input type="email"
                                   class="form-control"
                                   id="Email"
                                   name="data[email]"
                                   placeholder="your.email@example.com"
                                   required
                                   v-model="memberToEdit.email">
                            <span class="error" v-if="errors.email">{{ errors.email[0] }}</span>
                        </div>
                        <div class="form-group w-50 ms-2">
                            <label for="Phone">Phone number
                                <span class="minLabel">(in the following format: "+1 (555) 555-5555")</span>
                                <span class="required">*</span>:
                            </label>
                            <input class="form-control"
                                   id="Phone"
                                   name="data[phone]"
                                   minlength="17"
                                   placeholder="+1 (555) 555-5555"
                                   max="17"
                                   required
                                   type="tel"
                                   v-mask="'+# (###) ###-####'"
                                   v-model="memberToEdit.phone"
                                   :key="phoneInputKey"
                                   @keydown.capture="noLetters"
                                   @change="phoneInputKey++"
                                   ref="phone">
                            <span class="minLabel">Old Number: {{ oldPhone }}</span>
                            <span class="error" v-if="errors.phone">{{ errors.phone[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Subject">Report subject<span class="required">*</span>:</label>
                        <input type="text"
                               class="form-control"
                               id="Subject"
                               name="data[subject]"
                               placeholder="Repost subject..."
                               required
                               v-model="memberToEdit.subject">
                        <span class="error" v-if="errors.subject">
                            {{ errors.subject[0] }}
                        </span>
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div class="form-group w-50 me-2">
                            <label for="Company">Position:</label>
                            <input type="text"
                                   id="Company"
                                   name="data[position]"
                                   class="form-control"
                                   placeholder="Position..."
                                   v-model="memberToEdit.position">
                        </div>
                        <div class="form-group w-50 ms-2">
                            <label for="Position">Company:</label>
                            <span class="error" v-if="errors.company">{{ errors.company[0] }}</span>
                            <input type="text"
                                   id="Position"
                                   name="data[company]"
                                   class="form-control"
                                   placeholder="Company..."
                                   v-model="memberToEdit.company">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="About">About:</label>
                        <textarea class="form-control"
                                  id="About" rows="1"
                                  name="data[about]"
                                  placeholder="About me..."
                                  v-model="memberToEdit.about">
                    </textarea>
                    </div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                    <div class="d-flex flex-row justify-content-between mt-2">
                        <div class="form-group w-50 me-2">
                            <span>Current photo: {{ memberToEdit.photo.name || memberToEdit.photo }}</span>
                        </div>
                        <div class="form-group w-50 ms-2">
                            <label for="imgLoad">Upload New Image (.png, .jpg, .jpeg - up to 10Mb):</label>
                            <input type="file"
                                   class="form-control"
                                   id="imgLoad"
                                   name="photo"
                                   accept=".png, .jpg, .jpeg"
                                   ref="inputFile"
                                   @change="uploads"
                                   :key="fileInputKey">
                            <div class="flex flex-row justify-content-around">
                                <div class=" w-50" v-if="memberToEdit.photo">
                                    <span>Extension: {{
                                            extension
                                        }}</span>
                                </div>
                                <div class=" w-50" v-if="memberToEdit.photo">
                                <span>Size: {{
                                        fileSize
                                    }} Mb</span>
                                </div>
                            </div>

                            <span id="fileWarning" class="error" v-if="photo_error">
                            Max file size is 10 MB. Your is {{ fileSize }} MB</span>
                            <span class="error" v-if="errors.photo">{{ errors.photo[0] }}</span>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-between mt-2">
                        <button class="form-control delete-btn me-2" :disabled="defaultBtnActive"
                                @click="toggleEdit(`Set default photo (you can undo this until
                                    you submit edited data or just by quiting edit window)`, 'delete')">
                            Set default photo
                        </button>
                        <button class="form-control delete-btn ms-2" :disabled="retrieveBtnActive"
                                @click="toggleEdit(`Set old member's photo`, 'retrieve')">
                            Set old member's photo
                        </button>
                    </div>
                    <div class="d-flex flex-row justify-content-between mt-2">
                        <button class="form-control btn-danger me-2"
                                @click="toggleEdit('exit Edit Page', 'exit')">Cancel Changes
                        </button>
                        <button class="form-control btn-success ms-2" :disabled="btnActive"
                                @click="toggleEdit(`Edit Member's Data`, 'edit')">Submit Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>


</template>

<script>

import ConfirmModal from "./ConfirmModal";

export default {
    name: "EditMember",
    components: {ConfirmModal},
    props: {
        member: '',
        edit: false
    },
    data() {
        return {
            confirm: false,
            message: '',
            prop: '',
            mutableEdit: JSON.parse(this.edit),
            extension: null,
            size: null,
            countries: [],
            errors: [],
            error_exist: false,
            photo_error: false,
            fileSize: 0,
            memberToEdit: {},
            btnActive: false,
            defaultBtnActive: false,
            retrieveBtnActive: false,
            oldPhoto: '',
            oldPhone: '',
            fileInputKey: 0,
            phoneInputKey: 0,
        }
    },
    methods: {
        noDigits: function (event) {
            if ('1234567890'.indexOf(event.key) !== -1) {
                event.preventDefault()
            }
        },
        noLetters: function (event) {
            if (event.key === "Backspace" || event.key === "Tab") {
                return true;
            } else if ('1234567890'.indexOf(event.key) === -1) {
                console.log(event.key)
                event.preventDefault()
            }
            this.phoneUpdate();
        },
        uploads: function (event) {
            this.memberToEdit.photo = event.target.files['0'];
            this.getFileInfo();
            this.validateUpload();
            this.deactivateConfirmButton();
            if( this.defaultBtnActive === true){
                this.deactivateDefaultButton();
            }
            this.retrieveBtnActive = false;
        },
        getFileInfo: function () {
            let ext = "Couldn't resolve";
            const parts = this.memberToEdit.photo.name.split('.')
            if (parts.length > 1) {
                ext = '.' + parts.pop()
            }
            this.extension = ext;
            this.fileSize = (this.memberToEdit.photo.size / 1048576).toFixed(2);
        },

        sendData: function () {
            let data = new FormData();
            let newFileName = this.memberToEdit.email.split('@')[0];

            data.append('newName', newFileName);
            data.append('oldEmail', this.member.email);

            let array = Object.keys(this.memberToEdit);
            for (let i = 0; i < array.length; i++) {
                if (!['memberId', 'created_at', 'updated_at'].includes(array[i]))
                    data.append(array[i], this.memberToEdit[array[i]]);
            }

            axios.post('/editMember', data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(
                    response => {
                        console.log(response)
                        this.error_exist = false;
                    }
                ).catch(
                error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        this.error_exist = true;
                    } else {
                        this.error_exist = false;
                        console.log(error)
                    }

                })
                .then(() => {
                    if (this.error_exist) {
                        return false;
                    }
                    this.mutableEdit = false;
                    this.$emit("hideModal", this.mutableEdit);
                })

        },
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
        validateUpload() {
            if (this.memberToEdit.photo && this.memberToEdit.photo.size > 10485760) {
                this.fileSize = (this.memberToEdit.photo.size / 1048576).toFixed(2);
                this.photo_error = true;
                return false
            } else {
                this.photo_error = false;
                return true
            }
        },
        toggleEdit(message, prop) {


            if (this.btnActive && prop === 'edit') {
                return false;
            } else if (prop === 'edit') {
                if (!this.validateInputFields()) {
                    return false;
                }
            }
            this.prop = prop;
            this.message = message;
            this.confirm = true;
        },
        trackModal(data) {
            this.confirm = false;
            this.performModalAction(data)
        },
        performModalAction(data) {
            if (this.prop === 'exit' && data === true) {
                this.mutableEdit = false;
                this.$emit("hideModal", this.mutableEdit);
            } else if (this.prop === 'delete' && data === true) {
                this.memberToEdit.photo = 'default-image.png';
                this.$refs.inputFile.files = null;
                this.fileInputKey++;
                this.fileSize = null;
                this.extension = null;
                this.deactivateDefaultButton();
                this.photo_error = false;
                this.deactivateConfirmButton();
            } else if (this.prop === 'edit' && data === true) {
                this.sendData();
            } else if (this.prop === 'retrieve' && data === true) {
                this.retrieve();
                this.fileSize = null;
                this.extension = null;
                this.photo_error = false;
                this.deactivateConfirmButton();
            }
        },
        deactivateConfirmButton() {
            this.btnActive = this.photo_error;
        },
        validateInputFields() {
            return !(!this.memberToEdit.firstName ||
                !this.memberToEdit.lastName ||
                !this.memberToEdit.country ||
                !this.memberToEdit.subject ||
                !this.memberToEdit.birthDate ||
                !this.memberToEdit.phone ||
                !this.memberToEdit.email);
        },
        retrieve() {
            this.$refs.inputFile.value = null;
            this.memberToEdit.photo = this.oldPhoto;
            this.retrieveBtnActive = false;
            if (this.memberToEdit.photo !== 'default-image.png'){
                this.defaultBtnActive = false;
            } else {
                this.defaultBtnActive = true;
            }
            this.photo_error = false;
            this.fileInputKey++;
            this.deactivateConfirmButton();
            return true;
        },
        phoneUpdate() {
            setTimeout(() => {
                this.phoneInputKey++;
                this.$nextTick(() => this.$refs.phone.focus());
            }, 0)
        },
        deactivateDefaultButton(){
            if(this.defaultBtnActive === false && this.memberToEdit.photo === 'default-image.png'){
                this.defaultBtnActive = true;
            } else if(this.defaultBtnActive === true && this.memberToEdit.photo !== 'default-image.png'){
                this.defaultBtnActive = false;
            } else {
                return false;
            }
        },
    },
    beforeMount() {
        this.fetchCountries();
        Object.assign(this.memberToEdit, this.member);
        this.oldPhoto = this.memberToEdit.photo;
        this.oldPhone = this.memberToEdit.phone;
        delete this.memberToEdit.phone;
        this.memberToEdit.phone = this.oldPhone
        this.retrieveBtnActive = true;
        if (this.memberToEdit.photo === 'default-image.png'){
            this.deactivateDefaultButton();
        }
    },
    updated() {
        this.retrieveBtnActive = this.memberToEdit.photo === this.oldPhoto;
    }
}
</script>

<style scoped>

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

.background-modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
}

.content-modal {

    overflow: auto;
}

.minLabel {
    font-size: 0.75rem;
    color: grey;
}

.btn-success:disabled {
    background-color: lightgreen;
    border-color: lightgreen;
}

.error {
    display: inline-block;
    color: red;
    margin: 0.5rem;
}

.required {
    color: red;
}

</style>
