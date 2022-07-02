<script src="../../../../Albedo-Test-remake/www/source/views/index.js"></script>
<template>
    <form id="regForm" name="form" enctype="multipart/form-data" onsubmit="return false" method="post">

        <section v-if="step === 1">
            <h3>Step 1</h3>
            <h3>Personal Info:</h3>
            <p><span class="required">*</span> - Required</p>
            <p><label>First name <span class="minLabel">(Only letters and '`- symbols allowed)</span><span
                class="required">*</span>:
                <input id="firstNameIsValid" name="data[firstName]" placeholder="First name..."
                       pattern="^[.\D]{1,30}$"
                       maxlength="30"  required
                       @keydown.capture="noDigits($event)"
                       v-model="$data.form.firstName">
            </label>
                <span class="error" id="firstNameError"></span>

            </p>
            <p><label>Last name <span class="minLabel">(Only letters and '`- symbols allowed)</span><span
                class="required">*</span>:
                <input id="lastNameIsValid" name="data[lastName]" placeholder="Last name..."
                       pattern="^[.\D]{1,30}$"
                       maxlength="30"  required
                       @keydown.capture="noDigits($event)"
                       v-model="$data.form.lastName">
            </label>
                <span class="error" id="lastNameError"></span>
            </p>
            <p><label>Birth date<span class="required">*</span>:
                <input id="dateIsValid" name="data[birthDate]" placeholder="Birthdate..."
                       min="1900-01-01" max="2005-01-01" type="date" required
                       v-model="$data.form.birthDate">
            </label>
                <span class="error" id="dateError"></span>
            </p>
            <p><label>Report subject<span class="required">*</span>:
                <input id="subjectIsValid" name="data[subject]" placeholder="Repost subject..."
                       required v-model="$data.form.subject">
            </label>
                <span class="error" id="subjectError"></span>
            </p>
            <p><label>Country<span class="required">*</span>:
                <select class="country" id="countryIsValid" name="data[country]" required
                        v-model="$data.form.country">
                    <option selected disabled value="default" hidden>Choose Country</option>
                </select>
            </label>
                <span class="error" id="countryError"></span>
            </p>
            <p><label>Phone number <span class="minLabel">(in the following format: "+1 (555) 555-5555")</span><span
                class="required">*</span>:
                <input id="phoneIsValid" name="data[phone]" minlength="17"
                       data-mask="+0 (000) 000-0000" placeholder="+1 (555) 555-5555" required type="tel"
                       v-model="$data.form.phone">
            </label>
                <span class="error" id="phoneError"></span>
            </p>
            <p><label>Email<span class="required">*</span>:
                <input id="emailIsValid" name="data[email]" placeholder="your.email@example.com"
                       required type="email"
                       v-model="$data.form.email">
            </label>
                <span class="error" id="emailError"></span>
            </p>
        </section>

        <section v-if="step === 2">
            <h3>Step 2</h3>
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
            <span v-if="$data.form.photo">Extension: {{ $data.extension }}</span>
            <span v-if="$data.form.photo">Size: {{ $data.size }} Mb</span>
            <span id="fileWarning" class="error"></span>
        </section>

        <section v-if="step === 3">
            <h1 style="text-align: center">Registration complete! Share it with your friends!</h1>
            <div class="flex-row">
                links
            </div>
            <div class="finishAnchor">
                <a class="my-link" to="/" @click="toFirstStep">Back to 1st step</a>
            </div>
        </section>

        <div style="overflow:auto;">
            <div style="float:right;">
                <button type="submit" id="nextBtn" v-if="step === 1" @click="nextStep">Next</button>
                <button type="submit" id="step2Btn" v-if="step === 2" @click="nextStep">Finish</button>
            </div>
        </div>
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
            size: null
        }
    },
    methods: {
        nextStep: function () {
            this.step++;
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
        },
        getFileInfo: function () {
            let ext = "Couldn't resolve";
            const parts = this.form.photo.name.split('.')
            if (parts.length > 1) {
                ext = '.' + parts.pop()
            }
            this.extension = ext;
            this.size = (this.form.photo.size / 1048576).toFixed(2);
        }
    }
}
</script>

<style scoped>

</style>
