<template>
  <div class="list row">
    <div class="col-md-8">
    </div>
    <div class="col-md-6">
      <h4>Quinos Technical Test</h4>
      <ul class="list-group">
        <li class="list-group-item"
          :class="{ active: index == currentIndex }"
          v-for="(tutorial, index) in tutorials"
          :key="index"
          @click="setActiveTutorial(tutorial, index)"
        >
          {{ tutorial.full_name }}
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <div v-if="currentTutorial">
        <h4>Detail Students</h4>
        <div>
          <label><strong>Full Name:</strong></label> {{ currentTutorial.full_name }}
        </div>
        <div>
          <label><strong>Phone Number:</strong></label> {{ currentTutorial.phone_number }}
        </div>
        <div>
          <label><strong>City:</strong></label> {{ currentTutorial.city }}
        </div>
        <div>
          <label><strong>Code:</strong></label> {{ currentTutorial.code }}
        </div>

        <router-link :to="'/students/' + currentTutorial.id" class="badge badge-warning">Edit</router-link>
      </div>
      <div v-else>
        <br />
        <!-- <p>Please click on a Tutorial...</p> -->
      </div>
    </div>
  </div>
</template>

<script>
import Students from "../services/Students";

export default {
  name: "tutorials-list",
  data() {
    return {
      tutorials: [],
      currentTutorial: null,
      currentIndex: -1,
      title: ""
    };
  },
  methods: {
    retrieveTutorials() {
      Students.getAll()
        .then(response => {
          this.tutorials = response.data.data.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    refreshList() {
      this.retrieveTutorials();
      this.currentTutorial = null;
      this.currentIndex = -1;
    },

    setActiveTutorial(tutorial, index) {
      this.currentTutorial = tutorial;
      this.currentIndex = tutorial ? index : -1;
    },

    removeAllTutorials() {
      Students.deleteAll()
        .then(response => {
          console.log(response.data.data.data);
          this.refreshList();
        })
        .catch(e => {
          console.log(e);
        });
    },
    
    searchTitle() {
      Students.findByTitle(this.title)
        .then(response => {
          this.tutorials = response.data.data.data;
          this.setActiveTutorial(null);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  mounted() {
    this.retrieveTutorials();
  }
};
</script>

<style>
.list {
  text-align: left;
  max-width: 750px;
  margin: auto;
}
</style>
