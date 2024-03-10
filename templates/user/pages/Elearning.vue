<template>
    <div>
        <h1>Elearning</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Price</th>
                    <th>Enroll</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="course in courses" :key="course.id">
                    <td>{{ course.name }}</td>
                    <td>{{ course.price }}</td>
                    <td>
                        <button class="btn btn-primary" @click="enroll(course.id)">Enroll</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    computed: {
        courses() {
            return this.$store.getters.courses
        }
    },
    created() {
        this.$store.dispatch('fetchCourses')
    },
    methods: {
        enroll(courseId) {
            this.$store.dispatch('enroll', courseId)
        }
    }
}
</script>