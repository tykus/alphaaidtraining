<template>
    <div class="container">
        <input type="text" v-model="search">

        <course v-for="course in filteredCourses" :course="course" :key="course.id"></course>
    </div>
</template>

<script>
    import Course from './Course'
    export default {
        components: {Course},
        data() {
            return {
                search: '',
                courses: [
                    {
                        id: 1,
                        title: 'First Aid Course',
                        description: 'Lorem ipsum'
                    },
                    {
                        id: 2,
                        title: 'Basic First Aid Course',
                        description: 'this that these and those'
                    },
                ]
            }
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
