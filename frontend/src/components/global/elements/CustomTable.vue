<template>
    <v-simple-table class="elevation-3 rounded-lg pa-3">
        <template v-slot:default>
            <thead>
                <tr>
                    <th
                        v-for="(header, i) in headers"
                        :key="i"
                        class="text-center text-body-1"
                    >
                        {{ header.text }}
                    </th>
                    <th
                        v-if="Object.keys($listeners).length !== 0"
                        class="text-center"
                    ></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, i) in items" :key="i">
                    <td
                        class="text-center px-1"
                        v-for="(header, i) in headers"
                        :key="i"
                    >
                        <v-chip
                            class="d-flex justify-center"
                            label
                            color="lightBlue"
                            v-if="
                                item[header.value] &&
                                item[header.value].length > 0
                            "
                        >
                            <template v-if="header.default && header.formatter">
                                {{
                                    item[header.value]
                                        ? header.formatter(
                                              item[header.value],
                                              item
                                          )
                                        : header.default
                                }}
                            </template>
                            <template v-else-if="header.formatter">
                                {{
                                    item[header.value]
                                        ? header.formatter(
                                              item[header.value],
                                              item
                                          )
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
                    </td>
                    <td
                        v-if="Object.keys($listeners).length !== 0"
                        class="text-center"
                    >
                        <v-row justify="center">
                            <v-btn
                                small
                                v-if="$listeners.refresh"
                                icon
                                @click="$emit('refresh', i)"
                            >
                                <v-icon small>mdi-refresh</v-icon>
                            </v-btn>

                            <v-btn
                                small
                                v-if="$listeners.edit"
                                icon
                                @click="$emit('edit', i)"
                            >
                                <v-icon small>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn
                                small
                                v-if="$listeners.destroy"
                                icon
                                @click="$emit('destroy', i)"
                            >
                                <v-icon small>mdi-trash-can</v-icon>
                            </v-btn>
                            <v-btn
                                small
                                v-if="$listeners.remove"
                                icon
                                @click="$emit('remove', i)"
                            >
                                <v-icon small>mdi-minus-circle</v-icon>
                            </v-btn>
                        </v-row>
                    </td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
export default {
    name: "CustomTable",
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
</style>
