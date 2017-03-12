<template>
  <div id="date_birth">
    <select name="date_birth[day]">
        <option  v-for="day in days" :value="day">{{day}}</option>
    </select>
    <select name="date_birth[month]">
        <option  v-for="month in months" :value="month">{{month}}</option>
    </select>
    <select name="date_birth[year]">
        <option  v-for="year in years" :value="year">{{year}}</option>
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
  created : function()
  {
    var start = 1920;
    var end =  new Date().getFullYear() - 13;
    var i = 0;

    while (i < (end - start))
    {
      this.years[i] = start + i;
      ++i;
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
