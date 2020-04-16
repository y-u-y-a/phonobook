<template>
  <ul>
    <li
      v-for="(option, index) in options"
      :key="index">
      <input
        :id="group_name+'_'+option.label"
        :name="group_name"
        :value="option.value"
        :checked="default_value.indexOf(option.value)>=0"
        :required="required"
        type="checkbox"
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
        type: Array,
        type: true
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
input[type="checkbox"] {
  display: none;
}

// 非アクティブ時
label {
  color: blue;
}

// チェックされている次隣のlabel要素
input[type="checkbox"]:checked + label {
  color: red;
}
</style>
