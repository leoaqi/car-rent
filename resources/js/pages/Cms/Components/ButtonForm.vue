 <template>
    <button @click="handleClick"
    class="hover:cursor-pointer"
        :class="[
            {'text-sm font-medium bg-primary-500 hover:bg-primary-400 text-white py-[12px] px-[12px] rounded-[10px] w-fit' : type === 'block'},
            {'text-sm-3 font-medium bg-white border border-primary-500 border-solid hover:text-primary-400 text-primary-500 p-3 rounded-[10px]' : type === 'outline-border'},
        ]">
        {{ title }}
    </button>
</template>

<script setup>
const props = defineProps({
    title: {
        type: String,
        default: 'Button'
    },
    type : {
        type: String,
        default: 'block'
    }
})

const emit = defineEmits(['click']);

const handleClick = () => {
    if (!props.disabled) {
        emit('click');
    }
};
</script>