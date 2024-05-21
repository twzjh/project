<script>
export default {
  props: {
    valueData: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'text',
    },
    name: {
      type: String,
    },
    title: {
      type: String,
      default: '你的label名',
    },
  },
  emits: ['update'],
  data() {
    return {
      open: false,
      newValue: this.valueData,
    };
  },
  watch: {
    newValue: {
      handler(newValue) {
        this.$emit('update', newValue);
      },
    },
  },
};
</script>

<template>
  <div class="flex relative w-full">
    <input class='input' v-model="newValue" :type=type :name=name :id=name required>
    <label :for=name :class="{ hasValue: newValue !== '' }">{{ title }}</label>
    <slot></slot>
  </div>
</template>

<style scoped>
label{
  @apply text-dark-gray absolute top-4 left-3 text-[12px] w-4/6 bg-white tracking-wide px-[2px] cursor-text
}
.input{
  @apply relative w-full py-[12px] border-light-gary rounded-md
}
input:focus ~ label{
  top: -10px;
  width: auto;
  transition: all 0.5s ease;
}
.hasValue{
  top: -10px;
  width: auto;
}
/* 隱藏number input的增減按鈕 */
input[type='number']::-webkit-outer-spin-button,
input[type='number']::-webkit-inner-spin-button{
    -webkit-appearance:none;
    appearance:none;
    margin:0;
}
</style>
