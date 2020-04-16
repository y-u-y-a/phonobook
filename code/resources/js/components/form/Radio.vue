<template>
  <ul>
    <li v-for="(option, index) in options" :key="index">
      <input
        :id="group_name+'_'+option.label"
        :name="group_name"
        :value="option.value"
        :required="required"
        :checked="default_value==option.value"
        type="radio"
        @change="issueTrigger"
      />
      <label :for="group_name+'_'+option.label"></label>
    </li>
  </ul>
</template>


<script>
export default {
  props: {
    group_name: {
      type: String
    },

    required: {
      type: Boolean
    },

    options: {
      type: Array
    },

    default_value: {
      type: String,
      required: false
    }
  },

  methods: {
    issueTrigger(e) {
      this.$emit("trigger", e.target.value);
    }
  }
};
</script>


<style lang="scss" scoped>
input[type="radio"] {
  display: none;
}

// 非アクティブ時
label {
  color: blue;
}

// チェックされている次隣のlabel要素
input[type="radio"]:checked + label {
  color: red;
}
</style>
