<template>

    <form
        class="regForm"
        name="form"
        @submit.prevent=""
        method="post"
    >
        <h1 id="regHeader" style="text-align: center">To participate in the conference, please fill out the
            form</h1>
        <section v-if="step === 1">
            <h3>Step {{ step }}</h3>
            <h3>Personal Info:</h3>
            <p><span class="required">*</span> - Required</p>
            <p><label>First name <span class="minLabel">(Only letters and '`- symbols allowed)</span><span
                class="required">*</span>:
                <input id="firstNameIsValid" name="data[firstName]" placeholder="First name..."
                       pattern="^[.\D]{1,30}$"
                       maxlength="30" required
                       @keydown.capture="noDigits($event)"
                       v-model="$data.form.firstName">
            </label>
                <span class="error" id="firstNameError" v-if="errors.firstName">
                    {{ errors.firstName[0] }}
                </span>
            </p>
            <p><label>Last name <span class="minLabel">(Only letters and '`- symbols allowed)</span><span
                class="required">*</span>:
                <input id="lastNameIsValid" name="data[lastName]" placeholder="Last name..."
                       pattern="^[.\D]{1,30}$"
                       maxlength="30" required
                       @keydown.capture="noDigits($event)"
                       v-model="$data.form.lastName">
            </label>
                <span class="error" id="lastNameError" v-if="errors.lastName">
                    {{ errors.lastName[0] }}
                </span>
            </p>
            <p><label>Birth date<span class="required">*</span>:
                <input id="dateIsValid" name="data[birthDate]" placeholder="Birthdate..."
                       min="1900-01-01" max="2005-01-01" type="date" required
                       v-model="$data.form.birthDate">
            </label>
                <span class="error" id="dateError" v-if="errors.birthDate">
                    {{ errors.birthDate[0] }}
                </span>
            </p>
            <p><label>Report subject<span class="required">*</span>:
                <input id="subjectIsValid" name="data[subject]" placeholder="Repost subject..."
                       required v-model="$data.form.subject">
            </label>
                <span class="error" id="subjectError" v-if="errors.subject">
                    {{ errors.subject[0] }}
                </span>
            </p>
            <p><label>Country<span class="required">*</span>:
                <select class="country" id="countryIsValid" name="data[country]" required
                        v-model="$data.form.country">
                    <option selected disabled="disabled" value="null">Choose Country</option>
                    <option v-for="country in $data.countries" :value="country">{{ country }}</option>
                </select>
            </label>
                <span class="error" id="countryError" v-if="errors.country">
                    {{ errors.country[0] }}
                </span>
            </p>
            <p><label>Phone number
                <span class="minLabel">(in the following format: "+1 (555) 555-5555")</span>
                <span class="required">*</span>:
                <input id="phoneIsValid" name="data[phone]" minlength="17"
                       placeholder="+1 (555) 555-5555" required type="tel"
                       v-model="$data.form.phone"
                       v-mask="'+# (###) ###-####'">
            </label>
                <span class="error" id="phoneError" v-if="errors.phone">
                    {{ errors.phone[0] }}
                </span>
            </p>
            <p><label>Email<span class="required">*</span>:
                <input id="emailIsValid" name="data[email]" placeholder="your.email@example.com"
                       required type="email"
                       v-model="$data.form.email">
            </label>
                <span class="error" id="emailError" v-if="errors.email">
                    {{ errors.email[0] }}
                </span>
            </p>
            <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="submit" id="nextBtn" v-if="step === 1" @click="nextStep">Next</button>
                </div>
            </div>
        </section>


        <section v-if="step === 2">
            <h3>Step {{ step }}</h3>
            <h3>Additional info:</h3>
            <p><label>Company:
                <input name="data[company]" placeholder="Company..."
                       v-model="$data.form.company">
            </label></p>
            <p><label>Position:
                <input name="data[position]" placeholder="Position..."
                       v-model="$data.form.position">
            </label></p>
            <p><label>About me:
                <textarea name="data[about]" placeholder="About me..."
                          v-model="$data.form.about"></textarea>
            </label></p>
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
            <p><label>My Photo (.png, .jpg, .jpeg - up to 10Mb):
                <input id="imgLoad" name="photo" type="file" accept=".png, .jpg, .jpeg"
                       @change="uploads">
            </label></p>
            <span v-if="$data.form.photo">Extension: {{ extension }}</span>
            <br>
            <span v-if="$data.form.photo">Size: {{ fileSize }} Mb</span>
            <span id="fileWarning" class="error" v-if="photo_error">Max file size is 10 MB. Your is {{
                    fileSize
                }} MB</span>
            <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="submit" id="step2Btn" v-if="step === 2" @click="nextStep">Finish</button>
                </div>
            </div>
        </section>


        <section v-if="step === 3">
            <h1 style="text-align: center">Registration complete! Share it with your friends!</h1>
            <div class="flex-row">
                links
            </div>
            <div class="finishAnchor">
                <a class="my-link" href="/" @click="toFirstStep">Back to 1st step</a>
            </div>
        </section>
    </form>
</template>

<script>
export default {
    name: "RegistrationForm",
    data() {
        return {
            step: 1,
            totalStep: 3,
            form: {
                firstName: null,
                lastName: null,
                birthDate: null,
                country: null,
                subject: null,
                phone: null,
                email: null,
                position: null,
                company: null,
                about: null,
                photo: null,

            },
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
        nextStep: function () {
            if (this.step === 1) {
                this.sendData();
                this.trackChanges();
            } else if (this.step === 2) {
                this.updateData();
            }
        },
        toFirstStep: function () {
            this.step = 1;
        },
        noDigits: function (event) {
            if ('1234567890'.indexOf(event.key) !== -1) {
                event.preventDefault()
            }
        },
        uploads: function (event) {
            this.form.photo = event.target.files['0'];
            this.getFileInfo();
            this.validateUpload();
        },
        getFileInfo: function () {
            let ext = "Couldn't resolve";
            const parts = this.form.photo.name.split('.')
            if (parts.length > 1) {
                ext = '.' + parts.pop()
            }
            this.extension = ext;
            this.fileSize = (this.form.photo.size / 1048576).toFixed(2);
        },
        sendData: function () {
            axios.post('/send', {
                firstName: this.form.firstName,
                lastName: this.form.lastName,
                birthDate: this.form.birthDate,
                country: this.form.country,
                subject: this.form.subject,
                phone: this.form.phone,
                email: this.form.email,
            })
                .then(
                    response => {
                        console.log(this.errors)
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
                    this.persist();
                    this.countries = [];
                    this.step++;
                })
        },
        updateData: function () {
            // let data = new FormData();
            // data.append('photo', this.form.photo)

            if (this.photo_error) {
                return false;
            } else if (!this.dataExists()) {
                this.deleteStore();
                this.step++;
                return true;
            }
            axios.post('/update', {
                position: this.form.position,
                company: this.form.company,
                about: this.form.about,
                // photo: data,
                email: this.form.email,

            }).then(
                response => console.log(response.data)
            ).catch(
                error => console.log(error)
            );
            this.deleteStore();
            this.step++;
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
        trackChanges() {
            this.$emit('changeStep', {
                step: this.step
            })
        },
        persist() {
            localStorage.step = 2;
            localStorage.email = this.form.email;
        },
        deleteStore() {
            localStorage.clear()

        },
        validateUpload() {
            if (this.form.photo && this.form.photo.size > 10485760) {
                this.fileSize = (this.form.photo.size / 1048576).toFixed(2);
                this.photo_error = true;
                return false
            } else {
                this.photo_error = false;
                return true
            }
        },
        dataExists() {
            return !(!this.form.photo &&
                !this.form.about &&
                !this.form.company &&
                !this.form.position);
        }
    },
    beforeMount() {
        if (localStorage.email) {
            this.form.email = localStorage.email;
        }
        if (localStorage.step) {
            this.step = +localStorage.step
        } else {
            this.fetchCountries();
        }
    },


}
</script>

<style scoped>

</style>
