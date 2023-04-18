<template>
  <div v-if="currentTutorial" class="edit-form">
    <h4>Edit Data Student</h4>
    <form>
      <div class="form-group">
        <label for="title">Full Name</label>
        <input type="text" class="form-control" id="full_name"
          v-model="currentTutorial.full_name"
        />
      </div>
      <div class="form-group">
        <label for="description">Phone Number</label>
        <input type="text" class="form-control" id="phone_number"
          v-model="currentTutorial.phone_number"
        />
      </div>
      
      <div class="form-group">
        <label for="description">City</label>
        <input type="text" class="form-control" id="city"
          v-model="currentTutorial.city"
        />
      </div>

      <div class="form-group">
        <label for="description">Code</label>
        <input type="text" class="form-control" id="code"
          v-model="currentTutorial.code"
        />
      </div>

    </form>

    <button class="badge badge-danger mr-2"
      @click="deleteTutorial"
    >
      Delete
    </button>

    <button type="submit" class="badge badge-success"
      @click="updateTutorial"
    >
      Update
    </button>
    <p>{{ message }}</p>
  </div>

  <div v-else>
    <br />
    <p>Please click on a List Students...</p>
  </div>
</template>

<script>
import Students from "../services/Students";

export default {
  name: "tutorial",
  data() {
    return {
      currentTutorial: null,
      message: ''
    };
  },
  methods: {
    getTutorial(id) {
      Students.get(id)
        .then(response => {
          this.currentTutorial = response.data.data;
          console.log(response.data.data);
        })
        .catch(e => {
          console.log(e);
        });
    },

    updateTutorial() {
      Students.update(this.currentTutorial.id, this.currentTutorial)
        .then(response => {
          console.log(response.data);
          this.message = 'The tutorial was updated successfully!';
        })
        .catch(e => {
          console.log(e);
        });
    },

    deleteTutorial() {
      Students.delete(this.currentTutorial.id)
        .then(response => {
          console.log(response.data);
          this.$router.push({ name: "tutorials" });
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  mounted() {
    this.message = '';
    this.getTutorial(this.$route.params.id);
  }
};
</script>

<style>
.edit-form {
  max-width: 300px;
  margin: auto;
}
</style>
