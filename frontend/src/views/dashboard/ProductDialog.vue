
<template>
<v-app>
  <v-dialog
    v-model="dialogOpened"
    persistent
    max-width="700px"
    >
      <v-card v-if="dialogMode === 9">
        <v-card-title>
          <span class="text-h5">Settings</span>
        </v-card-title>
        <div style="display:flex">
          <v-card-text style="padding: 0px;">
            <v-container>
              <v-row justify="center">
                <v-col
                  cols="12"
                >
                  <v-card ref="form">
                    <v-card-text class="column" v-for="(header, index) in headerName" :key="index">
                      <v-text-field
                        v-model="header.text"
                        :rules="[val => (val || '').length > 0 || 'This field is required']"
                        :label="header.value"
                        placeholder="Type column name..."
                        required
                        :style="index === 0 ? 'padding-top: 16px' : ''"
                      ></v-text-field>
                      <v-checkbox
                        v-model="header.sortable"
                        label="Sorting"
                        @change="sortActive"
                      ></v-checkbox>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-text style="padding: 0px;">
            <v-container>
              <v-row justify="center">
                <v-col
                  cols="12"
                >
                  <v-card ref="form">
                    <v-card-text>
                      <v-select
                        :items="sizes"
                        label="Size of images"
                        dense
                        filled
                        v-model="selectedImgSizeData"
                        @change="changeImgSize"
                      ></v-select>
                    </v-card-text>
                    <v-text-field
                      v-model="selectProduct.category"
                      label="Разделитель для категорий"
                      style="padding-left: 16px; padding-right: 16px; padding-top: 0px;"
                    ></v-text-field>
                    <v-checkbox
                      style="padding: 16px"
                      label="Отображать дополнительные изображения"
                      v-model="notShowOtherImg"
                      @change="showOrNotOtherImg"
                    ></v-checkbox>
                  </v-card>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </div>
        <v-divider class="mt-12"></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="closeDialogOpened"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
      <v-card v-if="dialogMode !== 9">
        <v-card-title>
          <span v-if="dialogMode === 1" class="text-h5 formTitle">Add Product</span>
          <span v-else-if="dialogMode === 2" class="text-h5 formTitle">Edit Product</span>
          <span v-else class="text-h5 formTitle">Delete Product</span>
        </v-card-title>
        <v-card-text>
          <v-container v-if="dialogMode > 0">
            <v-form
              ref="productForm"
              v-model="valid"
              lazy-validation
            >
            <v-row>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.relation"
                label="Relation"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.category"
                label="Category"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.name"
                label="Product Name"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.model"
                label="Model"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.sku"
                label="Sku"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.url"
                label="Url"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.location"
                label="Location"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.ean"
                label="Ean"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.jan"
                label="Jan"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.mpn"
                label="Mpn"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.upc"
                label="Upc"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.discount_price"
                label="Discount_price"
                :rules="numericValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.price"
                label="Price"
                :rules="numericValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-select
                  v-model="selectProduct.stock_status"
                  :items="stock_status"
                  label="Stock_status"
                ></v-select>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.manufacturer"
                label="Manufacturer"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.description"
                label="Description"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.attributes"
                label="Attributes"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.images"
                label="Images"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.images_d"
                label="Images_d"
                :rules="textValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-text-field
                v-model="selectProduct.quantity"
                label="Quantity"
                :rules="numericValid"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
            >
                <v-select
                  item-text="text"
                  item-value="value"
                  v-model="selectProduct.status"
                  :items="status"
                  label="Status"
                ></v-select>
              </v-col>
            </v-row>
            </v-form>
          </v-container>
          <v-container v-else>
            <v-card-title class="text-h5 formTitle">Are you sure you want to delete this item?</v-card-title>
          </v-container>
        </v-card-text>
        <v-divider class="mt-12"></v-divider>
        <v-card-actions>
        <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="closeDialogOpened"
          >
              Cancel
          </v-btn>
          <v-btn
            v-if="dialogMode !== 0"
            color="blue darken-1"
            text
            @click="saveProductForm(selectProduct)"
          >
              Save
          </v-btn>
          <v-btn
            v-else
            color="blue darken-1"
            text
            @click="deleteProductForm(selectProduct.id)"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-app>
</template>

<script>
export default {
  name: 'ProductDialog',
  props: {
    dialogOpen: Boolean,
    otherImgShow: Boolean,
    dialogMode: Number,
    selectProduct: Object,
    headerName: Array,
    closeDialog: Function,
    saveProduct: Function,
    deleteProduct: Function,
    sortActive: Function,
    showOrNotOtherImg: Function,
    changeImgSize: Function,
    selectedImgSize: String
  },
  data: () => ({
    valid: true,
    textValid: [
      v => !!v || 'Field is required',
      v => (v && v.length <= 10) || 'Field must be less than 10 characters',
    ],
    numericValid: [
      v => !!v || 'Field is required',
      v => Number.isInteger(Number(v)) || "The value must be an integer number",
    ],
    dialogOpened: false,
    selectedImgSizeData : '',
    errorMessages: {},
    sizes: ["50х50", "100х100", "150х150", "200х200"],
    stock_status: ['Есть в Наличии', 'Нет в Наличии'],
    status: [
      {
        value: 1,
        text: 'Включен'
      },
      {
        value: 0,
        text: 'Выключен'
      }
    ]
  }),
  watch: {
    dialogOpen() {
      this.dialogOpened = this.dialogOpen;
      this.notShowOtherImg = this.otherImgShow;
    },
    selectedImgSize() {
      this.selectedImgSizeData = this.selectedImgSize;
    },
  },
  methods: {
    closeDialogOpened() {
      this.dialogOpened = false;
      this.closeDialog();
    },
    saveProductForm(selectProduct) {
      console.log('saveProductForm', this.$refs.productForm);
      this.$refs.productForm.validate();
      if (this.valid)
        this.saveProduct(selectProduct);
    }
  },
}
</script>

<style scoped>
  .member-dialog {
    width: 100%;
    padding: 20px;
  }
  .column {
    display: flex;
    padding-bottom: 0px;
    padding-top: 0px;
  }
</style>