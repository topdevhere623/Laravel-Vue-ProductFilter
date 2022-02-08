<template>
    <div class="items primary pa-2">
        <div
            class="item pb-4"
            v-for="(item, itemIndex) in items"
            :key="itemIndex"
        >
            <div
                class="cell"
                v-for="(header, headerIndex) in headers"
                :key="headerIndex"
            >
                <span class="secondary--text">{{ header.text }}</span>
                <v-chip class="d-flex justify-center" label color="lightBlue">
                    <template v-if="header.default && header.formatter">
                        {{
                            item[header.value]
                                ? header.formatter(item[header.value], item)
                                : header.default
                        }}
                    </template>
                    <template v-else-if="header.formatter">
                        {{
                            item[header.value]
                                ? header.formatter(item[header.value], item)
                                : ""
                        }}
                    </template>
                    <template v-else-if="header.default">
                        {{
                            item[header.value]
                                ? item[header.value]
                                : header.default
                        }}
                    </template>
                    <template v-else>
                        {{ item[header.value] }}
                    </template>
                </v-chip>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MobileTable",
    props: {
        headers: {
            required: true,
        },
        items: {
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>
.items {
    display: grid;

    .item {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(45%, 1fr));
        grid-gap: 5%;

        border-bottom: 1px solid #6477d8;
        .cell {
            display: grid;
            grid-auto-flow: row;
        }
    }
}
</style>
