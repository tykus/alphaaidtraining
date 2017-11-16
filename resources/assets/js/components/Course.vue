<template>
  <div class="card">
    <div class="card-image">
      <figure class="image is-4by3">
        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
      </figure>
    </div>
    <div class="card-content">
      <div class="content">
        <p class="title is-4">{{course.title}}</p>
        {{course.description}}
      </div>
    </div>
  </div>
</template>
<script>
    export default {
        props: ['course'],
        mounted() {
          console.log(this.course.name)
        }
    }
</script>

<style scoped>
  .media {
    border: 1px solid #dcdcdc;
  }
</style>
