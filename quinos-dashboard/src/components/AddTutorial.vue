<template>
  <div class="submit-form">
    <div v-if="!submitted">
      <div class="form-group">
        <label for="fullName">Full Name *</label>
        <input type="text" class="form-control" id="fullName" required v-model="student.full_name" name="title"
          @blur="checkName" />
        <span v-if="nameError">{{ nameError }}</span>
      </div>

      <div class="form-group">
        <label for="phoneNumber">Phone Number *</label>
        <input type="number" class="form-control" id="phoneNumber" required v-model="student.phone_number"
          name="phoneNumber" />
        <span v-show="!validPhoneNumber">Please enter a valid phone number</span>
      </div>

      <div class="form-group">
        <label for="city">City *</label>

        <select v-model="student.city" class="custom-select">
          <option disabled value="">Pilih kota</option>
          <option v-for="city in cities" :key="city.id" :value="city">{{ city }}</option>
        </select>
      </div>

      <div class="form-group">
        <label for="code">Code *</label>
        <input class="form-control" id="code" required v-model="student.code" name="code" />
      </div>

      <button @click="saveStudent" class="btn btn-success">Submit</button>
    </div>

    <div v-else>
      <h4>You submitted successfully!</h4>
      <button class="btn btn-success" @click="newTutorial">Add</button>
    </div>
  </div>
</template>

<script>
import Students from "../services/Students";


export default {
  watch: {
  },
  name: "add-tutorial",
  data() {
    return {
      student: {
        id: null,
        full_name: "",
        phone_number: "",
        city: "",
        code: ""
      },
      nameError: "",
      submitted: false,
      cities: ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang']
    };
  },
  methods: {
    saveStudent() {
      var data = {
        full_name: this.student.full_name,
        phone_number: this.student.phone_number,
        city: this.student.city,
        code: this.student.code
      };

      Students.create(data)
        .then(response => {
          this.student.id = response.data.data.id;
          console.log(response.data);
          this.submitted = true;
        })
        .catch(e => {
          alert("Code Has been existing, Please Change your Code!");
          console.log(e);
        });
    },

    checkName() {
      if (this.student.full_name.length < 3) {
        this.nameError = "Nama harus lebih dari 3 huruf";
      } else {
        this.nameError = "";
      }
    },

    validPhoneNumber() {
      return /^\d{10}$/.test(this.student.phone_number);
    },

    newTutorial() {
      this.submitted = false;
      this.student = {};
    }
  }
};
</script>

<style>
.submit-form {
  max-width: 300px;
  margin: auto;
}

.custom-select {
  width: 100%;
  height: 40px;
  padding: 0 20px;
  font-size: 16px;
  font-weight: 400;
  line-height: 40px;
  color: #333;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 4px;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='8' height='5'><path d='M1 1l3 3 3-3' stroke='%23333' fill='none' fill-rule='evenodd'/></svg>");
  background-repeat: no-repeat;
  background-position: right 15px center;
}
</style>
