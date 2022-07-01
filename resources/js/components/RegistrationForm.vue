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
                       @keydown.capture="noDigits($event)">
            </label>
                <span class="error" id="firstNameError"></span>
            </p>
            <p><label>Last name <span class="minLabel">(Only letters and '`- symbols allowed)</span><span
                class="required">*</span>:
                <input id="lastNameIsValid" name="data[lastName]" placeholder="Last name..."
                       pattern="^[.\D]{1,30}$"
                       maxlength="30"  required
                       @keydown.capture="noDigits($event)">
            </label>
                <span class="error" id="lastNameError"></span>
            </p>
            <p><label>Birth date<span class="required">*</span>:
                <input id="dateIsValid" name="data[date]" placeholder="Birthdate..."
                       min="1900-01-01" max="2005-01-01" type="date" required>
            </label>
                <span class="error" id="dateError"></span>
            </p>
            <p><label>Report subject<span class="required">*</span>:
                <input id="subjectIsValid" name="data[subject]" placeholder="Repost subject..."
                       required>
            </label>
                <span class="error" id="subjectError"></span>
            </p>
            <p><label>Country<span class="required">*</span>:
                <select class="country" id="countryIsValid" name="data[country]" required>
                    <option selected disabled value="default" hidden>Choose Country</option>
                </select>
            </label>
                <span class="error" id="countryError"></span>
            </p>
            <p><label>Phone number <span class="minLabel">(in the following format: "+1 (555) 555-5555")</span><span
                class="required">*</span>:
                <input id="phoneIsValid" name="data[phone]" minlength="17"
                       data-mask="+0 (000) 000-0000" placeholder="+1 (555) 555-5555" required type="tel">
            </label>
                <span class="error" id="phoneError"></span>
            </p>
            <p><label>Email<span class="required">*</span>:
                <input id="emailIsValid" name="data[email]" placeholder="your.email@example.com"
                       required type="email">
            </label>
                <span class="error" id="emailError"></span>
            </p>
        </section>

        <section v-if="step === 2">
            <h3>Step 2</h3>
            <h3>Additional info:</h3>
            <p><label>Company:
                <input name="data[company]" placeholder="Company...">
            </label></p>
            <p><label>Position:
                <input name="data[position]" placeholder="Position...">
            </label></p>
            <p><label>About me:
                <textarea name="data[about]" placeholder="About me..."></textarea>
            </label></p>
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
            <p><label>My Photo (.png, .jpg, .jpeg - up to 10Mb):
                <input id="imgLoad" name="photo" type="file" accept=".png, .jpg, .jpeg">
            </label></p>
            <span id="e-fileinfo"></span>
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

            }
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
        }
    }
}
</script>

<style scoped>

</style>
