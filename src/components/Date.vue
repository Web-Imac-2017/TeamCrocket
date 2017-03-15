<template>
  <div id="date_birth">
    <select name="date_birth2[day]">
        <option v-for="day in days" :value="day">{{day}}</option>
    </select>
    <select name="date_birth2[month]">
        <option v-for="month in months" :value="month">{{month}}</option>
    </select>
    <select name="date_birth2[year]">
        <option v-for="year in years" :value="year">{{year}}</option>
    </select>
  </div>
</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

export default {
  data() {
    return {
      years : [],
      months : [],
      days: [],
    }
  },
  created : function(){
    var start = new Date().getFullYear();
    var end = start - 100;
    var i, y;

    for(i = 0, y = start; y > end; y--, i++){
      this.years[i] = y;
    }

    for (i = 0; i < 12; ++i)
    {
      this.months[i] = i + 1;
    }

    for (i = 0; i < 31; ++i)
    {
      this.days[i] = i + 1;
    }
  }
}


</script>
