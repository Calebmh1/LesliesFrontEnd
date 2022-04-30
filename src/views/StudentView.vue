<template>
    <div>
        <viewStudents />
    </div>
</template>


<script>
    import viewStudents from "@/components/ViewStudents.vue";
    
    export default {
        name: 'AddStudentView',
        components: {
            viewStudents
        }
    }
</script>