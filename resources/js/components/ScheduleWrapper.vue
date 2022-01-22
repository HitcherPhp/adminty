<template>
    <div>
        <schedule-customize  ref="schedule_customize" v-if="schedule_active"></schedule-customize>
    </div>
</template>

<script>
import ScheduleCustomize from "./ScheduleCustomize.vue";

export default {
    name: "ScheduleWrapper",
    components: {
        ScheduleCustomize,
    },

    data(){
        return {
            schedule_active:false
        }
    },

    methods:{

        enable(){
            // console.log('enable')
            this.schedule_active = true
        },

        disable(){
            // console.log('disable')
            this.schedule_active = false
        },

    }
}

</script>
