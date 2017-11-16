<template>
  <div class="columns">
    <div class="column is-2">
      <course-search></course-search>
    </div>
    <div class="column">
      <div class="columns is-multiline">
        <div class="column is-one-quarter" v-for="course in filteredCourses">
          <course :course="course" :key="course.id"></course>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import Course from './Course'
    import CourseSearch from './CourseSearch'
    export default {
        components: {Course, CourseSearch},
        data() {
            return {
                search: '',
                courses: []
            }
        },
        mounted () {
          axios.get('api/courses').then((response) => this.courses = response.data.courses)
        },
        computed: {
            filteredCourses() {
                if (this.search !== '') {
                    return this.courses.filter(course => {
                        return course.title.toLowerCase().indexOf(this.search.toLowerCase()) >= 0
                            || course.description.toLowerCase().indexOf(this.search.toLowerCase()) >= 0
                    })
                }
                return this.courses
            }
        }
    }
</script>
