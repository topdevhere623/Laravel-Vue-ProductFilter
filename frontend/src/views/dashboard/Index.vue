<template>
  <v-app>
    <div style="display: flex; justify-content: center; margin-top: 10px;border-bottom: 2px solid gray; padding-bottom: 10px; margin-left: 30px; margin-right: 30px">
      <a href="#" style="border-right: 2px solid; padding-right: 10px; height: 19px; font-size: 14px; font-weight: bold">Каталог</a>
      <a href="#" style="border-right: 2px solid; padding-right: 10px; margin-left: 10px; height: 19px; font-size: 14px; font-weight: bold">Магазины</a>
      <a href="#" style="border-right: 2px solid; padding-right: 10px; margin-left: 10px; height: 19px; font-size: 14px; font-weight: bold">Категории</a>
      <a href="#" style="border-right: 2px solid; padding-right: 10px; margin-left: 10px; height: 19px; margin-left: 10px; font-size: 14px; font-weight: bold">Бренды</a>
      <a href="#" style="border-right: 2px solid; padding-right: 10px; margin-left: 10px; height: 19px; margin-left: 10px; font-size: 14px; font-weight: bold">Пользователи</a>
      <a href="#" style="border-right: 2px solid; padding-right: 10px; margin-left: 10px; height: 19px; margin-left: 10px; font-size: 14px; font-weight: bold">Отзывы</a>
      <a href="#" style="border-right: 2px solid; padding-right: 10px; margin-left: 10px; height: 19px; margin-left: 10px; font-size: 14px; font-weight: bold">SEO</a>
      <a href="#" style="border-right: 2px solid; padding-right: 10px; margin-left: 10px; height: 19px; margin-left: 10px; font-size: 14px; font-weight: bold">Настройки</a>
      <a style="padding-right: 10px; margin-left: 10px; height: 19px; margin-left: 10px; font-size: 14px; font-weight: bold" @click="handleLogout" >Выход </a>
    </div>
    <div class="main">
      <v-card-title style="display:flex; align-items: center; justify-content:space-between; margin-right: 30px" class="header">
          <div style="display: flex;">
            <span style="font-size: 14px">
              Всего: {{ totalProducts }} товаров
            </span>
            <v-spacer></v-spacer>
            <a class="mb-2" style="margin-left:10px; font-size: 14px" @click="createProductDialog">:: Добавить товар ::</a>
            <a class="mb-2" style="margin-left:10px; font-size: 14px" @click="settings">Настройки</a>
          </div>
          <div>
            <span style="font-size: 14px">
              Фильтр: <a @click="getProductAll">Все</a> /
              <a @click="notUpdatedProducts">Давно не обнавлялись</a> / <a @click="updatedToday">Обнавлялись сегодня</a>
            </span>
          </div>
      </v-card-title>
      <div class="search_tab">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="ID, Название или Модель"
          outlined
          dense
          hide-details
          class="search_input"
          :height="20"
        ></v-text-field>
        <v-btn small style="background-color: teal; color: white; margin-bottom: 14px; margin-left: 10px" @click="searchProducts">
          <span style="font-size: 14px; width:50px;">Искать</span>
        </v-btn>
        <div style="display: flex; width: 850px; margin-left: 10px; margin-bottom: 10px">
          <SelectionSearch
          type="category"
          title="Категория"
          :states="categories"
          :changeFilter="changeFilter"
          :clearFilter="clearFilter"
          style="border-radius: 4px"
          />
          <SelectionSearch
            type="brand"
            title="Бренд"
            :states="brands"
            :changeFilter="changeFilter"
            :clearFilter="clearFilter"
            style="border-radius: 4px; margin-left:10px"
          />
          <a v-if="showClearAllFilterText" style="margin-left:10px; font-size: 14px; width: 300px" @click="clearAllFilters">:: Сбросить все фильтры</a>
        </div>
      </div>
      <v-card-title class="header" style="display:flex; align-items: center; justify-content:space-between; margin-right: 30px">
        <div style="display: flex;">
          <span style="font-size: 14px">
            {{ itemsPerPage * (page - 1) + 1 }} ~ {{ itemsPerPage * page }} из {{ totalProducts }} найденных :: С отмеченными:
          </span>
          <v-spacer></v-spacer>
          <v-select
            item-text="text"
            item-value="value"
            v-model="defaultSelectedStatus"
            :items="status"
            label="Статус"
            outlined
            style="width: 150px; margin-left:10px"
            @change="changeStatus"
          ></v-select>
          <v-btn small style="background-color: teal; color: white; margin-bottom: 14px; margin-left: 10px" @click="changeSelectedStatus">
            <span style="font-size: 14px;">Применить</span>
          </v-btn>
          <v-select v-model="selectedHeaders" :items="headers" label="Select Columns" class="selectedHeaders" multiple solo dense return-object>
            <template v-slot:selection="{ index }">
              <span v-if="index === 1" class="grey--text caption">Число колон - {{ selectedHeaders.length }}</span>
            </template>
          </v-select>
        </div>
        <div class="text-center pt-2 pagination" style="margin-top: -20px">
          <v-pagination
            v-model="page"
            :length="pageCount"
            :total-visible="7"
            color="teal"
            class="pagination"
          ></v-pagination>
          <v-text-field
            :value="itemsPerPage"
            v-model="itemsPerPage"
            label="Rows:"
            type="number"
            min="-1"
            max="15"
            @input="itemsPerPage = parseInt($event, 10)"
            class="centered-input pageInput"
          ></v-text-field>
        </div>
      </v-card-title>
      <!-- <v-select
            :items="items"
            label="Choose Database..."
            dense
            filled
          ></v-select> -->
      <v-data-table
        :headers="showHeaders"
        :items="products"
        sort-by="calories"
        class="mainTable"
        :search="search"
        :single-select="singleSelect"
        item-key="name"
        show-select
        v-model="checkedProductList"
        :items-per-page="itemsPerPage"
        :header-props="{ sortIcon: null }"
        hide-default-footer
      >
        <template v-slot:top>
          <v-toolbar
            flat
          >
            <ProductDialog
              :dialogOpen="dialogOpen"
              :dialogMode="dialogMode"
              :selectProduct="selectProduct"
              :headerName="headerName"
              :closeDialog="closeDialog"
              :saveProduct="saveProduct"
              :deleteProduct="deleteProduct"
              :sortActive="sortActive"
              :otherImgShow="otherImgShow"
              :showOrNotOtherImg="showOrNotOtherImg"
              :changeImgSize="changeImgSize"
              :selectedImgSize="selectedImgSize"
            />
          </v-toolbar>
        </template>
        <template v-slot:[`item.name`]="{ item }" class="nameWidth">
          <a @click="editProductDialog(item)" style="color: teal">
            {{ item.name }}
          </a>
        </template>
        <template v-slot:[`item.url`]="{ item }">
          <a v-bind:href="item.url" style="color: teal">
            Cсылка
          </a>
        </template>
        <template v-slot:[`item.location`]="{ item }">
          <a v-bind:href="item.url" style="color: teal">
            {{ item.location }}
          </a>
        </template>
        <template v-slot:[`item.stock_status`]="{ item }">
          <span :class="item.stock_status.slice(0,3) === 'Нет' ? 'false' : 'true'">
            {{ item.stock_status }}
          </span>
        </template>
        <template v-slot:[`item.manufacturer`]="{ item }">
          {{ item.manufacturer }}
        </template>
        <template v-slot:[`item.description`]="{ item }">
          <v-tooltip bottom open-delay="500" max-width="300px">
            <template v-slot:activator="{ on, attrs }">
              <p class="truncate" v-bind="attrs"
                v-on="on">
                {{ getCutText(item.description) }}[...]
              </p>
            </template>
            <span class="tooltip">{{ getFormated(item.description) }}</span>
          </v-tooltip>
        </template>
        <template v-slot:[`item.attributes`]="{ item }">
          <v-tooltip bottom open-delay="500" max-width="300px">
            <template v-slot:activator="{ on, attrs }">
              <p class="truncate" v-bind="attrs"
                v-on="on">
                {{ getCutText(item.attributes) }}[...]
              </p>
            </template>
            <span class="tooltip">{{ getFormated(item.attributes) }}</span>
          </v-tooltip>
        </template>
        <template v-slot:[`item.images`]="{ item }">
          <div v-if="otherImgShow">
            <div v-if="selectedImgSize === '50х50' || selectedImgSize === ''">
              <img
                v-for="(image, index) in item.images.split(',')" :key="index"
                :src="image"
                :class="index == 0 ? 'mainImg1':'otherImg1'"
              />
            </div>
            <div v-if="selectedImgSize === '100х100'">
              <img
                v-for="(image, index) in item.images.split(',')" :key="index"
                :src="image"
                :class="index == 0 ? 'mainImg2':'otherImg2'"
              />
            </div>
            <div v-if="selectedImgSize === '150х150'">
              <img
                v-for="(image, index) in item.images.split(',')" :key="index"
                :src="image"
                :class="index == 0 ? 'mainImg3':'otherImg3'"
              />
            </div>
            <div v-if="selectedImgSize === '200х200'">
              <img
                v-for="(image, index) in item.images.split(',')" :key="index"
                :src="image"
                :class="index == 0 ? 'mainImg4':'otherImg4'"
              />
            </div>
          </div>
          <div v-if="!otherImgShow">
            <div v-if="selectedImgSize === '50х50' || selectedImgSize === ''">
              <img
                :src="item.images.split(',')[0]"
                class="mainImg1"
              />
            </div>
            <div v-if="selectedImgSize === '100х100'">
              <img
                :src="item.images.split(',')[0]"
                class="mainImg2"
              />
            </div>
            <div v-if="selectedImgSize === '150х150'">
              <img
                :src="item.images.split(',')[0]"
                class="mainImg3"
              />
            </div>
            <div v-if="selectedImgSize === '200х200'">
              <img
                :src="item.images.split(',')[0]"
                class="mainImg4"
              />
            </div>
          </div>
        </template>
        <template v-slot:[`item.date_added`]="{ item }">
          <span>
            {{ item.date_added.slice(0, 10) }}
          </span>
        </template>
        <template v-slot:[`item.date_modified`]="{ item }">
          <span>
            {{ item.date_modified.slice(0, 10) }}
          </span>
        </template>
        <template v-slot:[`item.status`]="{ item }">
          <span :class="item.status == 1 ? 'true' : 'false'">
            {{ item.status == 1 ? 'Включен' : 'Выключен' }}
          </span>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="editProductDialog(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            @click="deleteProductDialog(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
      <div class="text-center pt-2 pagination">
        <v-pagination
          v-model="page"
          :length="pageCount"
          :total-visible="7"
          color="teal"
          class="pagination"
        ></v-pagination>
        <v-text-field
          :value="itemsPerPage"
          v-model="itemsPerPage"
          label="Rows:"
          type="number"
          min="-1"
          max="15"
          @input="itemsPerPage = parseInt($event, 10)"
          class="centered-input"
        ></v-text-field>
      </div>
    </div>
  </v-app>
</template>

<script>
import ProductDialog from './ProductDialog.vue';
import SelectionSearch from './SelectionSearch.vue';
const initProduct = {
  id: 0,
  relation:'',
  category: '',
  name:'',
  model:'',
  sku:'',
  url:'',
  location:'',
  ean:'',
  jan:'',
  mpn:'',
  upc:'',
  discount_price:'',
  price:'',
  stock_status:'Есть в Наличии',
  manufacturer:'',
  description:'',
  attributes:'',
  images:'',
  images_d:'',
  quantity:'',
  status: 1,
}
export default {
  components: {
    ProductDialog,
    SelectionSearch,
  },
  data: () => ({
    pageLoading: false,
    dateOfToday: '',
    checkedProductList: [],
    checkedProductIds: [],
    defaultSelectedStatus: 1,
    status: [
      {
        value: 1,
        text: 'Включить'
      },
      {
        value: 0,
        text: 'Выключить'
      }
    ],
    startCount: 0,
    endCount: 10,
    brands: [],
    categories: [],
    selectedImgSize: '',
    otherImgShow: true,
    items: [],
    page: 1,
    pageCount: 10,
    itemsPerPage: 10,
    dialogOpen: false,
    dialogMode: 1,
    search: '',
    brand: '',
    category: '',
    dialogDelete: false,
    singleSelect: false,
    selected: [],
    selectedHeaders: [],
    headers: [],
    headersMap: [
      { text: 'id', value: 'id', sortable: true, align: "center", class: ''},
      { text: 'relation', value: 'relation', sortable: true,  align: "center", class: ''},
      { text: 'category', value: 'category', sortable: true,  align: "center", class: ''},
      { text: 'name', value: 'name', sortable: true,  align: "center", class: '' },
      { text: 'model', value: 'model', sortable: true,  align: "center", class: '' },
      { text: 'sku', value: 'sku', sortable: false,  align: "center" },
      { text: 'url', value: 'url', sortable: false,  align: "center" },
      { text: 'location', value: 'location', sortable: false,  align: "center" },
      { text: 'ean', value: 'ean', sortable: false,  align: "center" },
      { text: 'jan', value: 'jan', sortable: false,  align: "center" },
      { text: 'mpn', value: 'mpn', sortable: false,  align: "center" },
      { text: 'upc', value: 'upc', sortable: false,  align: "center" },
      { text: 'discount_price', value: 'discount_price', sortable: false,  align: "center" },
      { text: 'price', value: 'price', sortable: true,  align: "center", class: '' },
      { text: 'stock_status', value: 'stock_status', sortable: false,  align: "center" },
      { text: 'manufacturer', value: 'manufacturer', sortable: true, align: "center", class: '' },
      { text: 'description', value: 'description', sortable: false, align: "center" },
      { text: 'attributes', value: 'attributes', sortable: false, align: "center" },
      { text: 'images', value: 'images', sortable: false, align: "center" },
      { text: 'images_d', value: 'images_d', sortable: false,align: "center" },
      { text: 'date_added', value: 'date_added', sortable: false, align: "center" },
      { text: 'date_modified', value: 'date_modified', sortable: false, align: "center" },
      { text: 'quantity', value: 'quantity', sortable: false, align: "center" },
      { text: 'status', value: 'status', sortable: false, align: "center" },
      { text: 'Actions', value: 'actions', sortable: false, align: "center" },
    ],
    products: [],
    editedIndex: -1,
    selectProduct: initProduct,
    totalProducts: 0,
    sorting_type: 0,
    showClearAllFilterText: false,
  }),

  created () {
    this.headers = this.headersMap;
    this.selectedHeaders = this.headers;
    this.headerName = this.headersMap;
    this.getProducts();
    this.getBrand();
    this.getCategory();
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'Add Product' : 'Edit Product'
    },
    showHeaders () {
      return this.headers.filter(s => this.selectedHeaders.includes(s));
    },
    compoundProperty() {
        return [this.search, this.category, this.brand, this.sorting_type, this.dateOfToday].join()
    }
  },

  mounted() {
    for(let i = 0; i < this.headersMap.length; i++) {
      if(this.headersMap[i].sortable === true) {
        this.headersMap[i].class = "teal--text";
      } else {
        this.headersMap[i].class = "";
      }
    }
  },

  watch: {
    page(val) {
      console.log('page', val);
      this.getProducts(this.search, this.brand, this.category, val, this.itemsPerPage);
    },
    itemsPerPage(val) {
      console.log('itemsPerPage', val);
      this.getProducts(this.search, this.brand, this.category, this.page, val);
    },
    compoundProperty() {
      this.showClearAllFilterText = true;
    }
  },

  methods: {
    showOrNotOtherImg() {
      this.otherImgShow = !this.otherImgShow;
    },
    changeImgSize(size) {
      console.log('changeImgSize', size);
      this.selectedImgSize = size;
    },
    changeStatus(status) {
      console.log('selectProduct', status, this.selectProduct);

    },
    clearAllFilters() {
      console.log("CLEAR")
      this.search = '';
      this.category = '';
      this.brand = '';
      this.sorting_type = 0;
      this.dateOfToday = '';
      this.getProducts();
    },
    sortActive () {
      console.log("Rex")
      for(let i = 0; i < this.headersMap.length; i++) {
        if(this.headersMap[i].sortable === true) {
          this.headersMap[i].class = "teal--text";
        } else {
          this.headersMap[i].class = "";
        }
      }
    },
    getFormated(item) {
      let text = item;
      let removedTags = text.replace(/<\/?[^>]+(>|$)/g, "");
      let styledText = removedTags.replaceAll('<br>', '\n');
      return styledText;
    },
    getCutText(item) {
      let text = item;
      let removedTags = text.replace(/<\/?[^>]+(>|$)/g, "");
      let styledText = removedTags.replaceAll('<br>', '\n');
      let cutText = styledText.slice(0, 30)
      return cutText;
    },
    searchProducts() {
      this.getProducts(this.search, this.brand, this.category, this.page, this.itemsPerPage);
    },

    // Dialog Parts
    showDialog(dialogMode) {
      this.dialogOpen = true
      this.dialogMode = dialogMode
    },
    closeDialog() {
      this.dialogOpen = false
    },
    createProductDialog() {
      this.selectProduct = initProduct;
      this.showDialog(1)
    },
    editProductDialog(Product) {
      this.selectProduct = Product
      this.showDialog(2)
    },
    deleteProductDialog(Product) {
      this.selectProduct = Product
      this.showDialog(0)
    },
    settings() {
      this.showDialog(9)
    },
    changeFilter(type, val) {
      console.log("Seleceted Items", type, val);
      if(type === 'brand') {
        this.brand = val;
      }
      else if (type === 'category') {
        this.category = val;
      }
      this.getProducts(this.search, this.brand, this.category);
    },
    clearFilter(type) {
      if(type === 'brand') {
        this.brand = '';
      }
      else if (type === 'category') {
        this.category = '';
      }
      this.getProducts(this.search, this.brand, this.category);
    },

    // Api parts
    getProducts(search = '', brand = '', category = '', page = 1, limit = 10, date_added = '', date_modified = '', sorting_type = '0') {
      this.pageLoading = true;
      window.axios
        .get(`/api/products?search_key=${search}&manufacturer=${brand}&category=${category}&page=${page}&limit=${limit}&date_added=${date_added}&date_modified=${date_modified}&sorting_type=${sorting_type}`)
        .then((res) => {
          console.log(res);
          this.products = res.data.products;
          this.page = parseInt(res.data.page);
          this.pageCount = res.data.total_pages;
          this.pageLoading = false;
          console.log('pageCount', this.pageCount);
          this.totalProducts = res.data.total_counts;
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    getCategory() {
      window.axios
        .get("/api/products/getCategories")
        .then((res) => {
          console.log(res);
          if (res.data.length > 0) {
            this.categories = res.data.map(item => item.category);
            console.log("categ", this.categories)
            for(let i = 0; i < this.categories.length; i ++) {
              this.categories[i].split('|')
            }
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    getBrand() {
      window.axios
        .get("api/products/getBrands")
        .then((res) => {
          console.log(res);
          if (res.data.length > 0) {
            this.brands = res.data.map(item => item.manufacturer);
          }
        }).catch((err) => {
          console.log("err", err);
        });
    },
    saveProduct(selectedProduct) {
      if (selectedProduct.id === 0) {
        // Create
        window.axios.post('/api/products', selectedProduct)
          .then(() => {
            this.closeDialog()
            this.getProducts()
          })
          .catch((err) => {
            console.log('err', err)
          })
      }
      else {
        // Update
        window.axios.put(`/api/products/${selectedProduct.id}`, selectedProduct)
          .then(() => {
            this.closeDialog()
          })
          .catch((err) => {
            console.log('err', err)
          })
      }
    },

    deleteProduct(ProductId) {
      console.log('ProductId', ProductId)
      // Delete
      window.axios.delete(`/api/products/${ProductId}`)
        .then(() => {
          this.closeDialog()
          this.getProducts()
          console.log("DELETING")
        })
        .catch((err) => {
          console.log('err', err)
        })
    },
    async handleLogout() {
      await this.$auth.logout();
      await this.$router.push({ name: "login" });
    },

    notUpdatedProducts() {
      this.sorting_type = 1;
      this.getProducts(this.search, this.brand, this.category, this.page, this.itemsPerPage, '', this.date_modified, this.sorting_type);
    },

    getProductAll() {
      this.sorting_type = 0;
      this.dateOfToday = '';
      this.getProducts();
    },

    updatedToday() {
      this.sorting_type = 0;
      this.dateOfToday = new Date().toISOString().slice(0, 10);
      console.log("Today", this.dateOfToday)
      this.getProducts(this.search, this.brand, this.category, this.page, this.itemsPerPage, '', this.dateOfToday, this.sorting_type);
    },

    changeSelectedStatus() {
      if (this.checkedProductList.length > 0) {
        this.checkedProductIds = this.checkedProductList.map(item => item.id);
        // Create
        window.axios.post(`/api/products/updateProductsStatus`, {
          status: this.defaultSelectedStatus,
          product_ids: this.checkedProductIds
        })
          .then(() => {
            console.log("Successfully Changed")
            this.getProducts(this.search, this.brand, this.category, this.page, this.itemsPerPage, '', this.dateOfToday, 1);
          })
          .catch((err) => {
            console.log('err', err)
          })
      }
    }
  }
}
</script>

<style scoped>
  .v-data-table >>> td {
    border: 0.5px solid gray;
    font-size: 12px !important;
    padding: 5px !important;
  }
  .v-data-table >>> th {
      border: 0.5px solid gray;
      font-size: 12px !important;
      padding: 5px !important;
      background-color: white !important;
  }
  .v-data-table >>> tr:nth-of-type(odd) {
    background-color: #ebebeb;
  }
  .v-data-table >>> header {
    height: 0px !important;
  }
  .header {
    margin-top: 10px !important;
    padding: 0px;
    margin-left: 30px;
  }
  .selectedHeaders {
    margin-left: 20px;
    width: 200px;
    margin-top: -6px !important;
  }
  .search_input {
    width: 90px;
  }
  .v-btn >>> span {
    font-size: 12px !important;
  }
  .v-text-field >>> label {
      font-size: 0.8em;
      top: 3px !important;
  }
  .v-text-field >>> fieldset {
      height: 30px !important;
  }
  .v-text-field >>> i {
      margin-bottom: 12px !important;
  }
  .v-text-field >>> input {
      margin-bottom: 16px !important;
  }
  .v-card__title {
    margin-top: -45px;
  }
  .formTitle {
    margin-top: 60px;
  }
  .truncate {
    max-width: 100px;
    white-space: initial;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0px !important;
  }
  .mainImg1 {
    width: 50px;
    height: 30px;
  }
  .mainImg2 {
    width: 100px;
    height: 60px;
  }
  .mainImg3 {
    width: 150px;
    height: 80px;
  }
  .mainImg4 {
    width: 200px;
    height: 120px;
  }
  .otherImg1 {
    width: 10px;
    height: 7px;
  }
  .otherImg2 {
    width: 20px;
    height: 14px;
  }
  .otherImg3 {
    width: 30px;
    height: 21px;
  }
  .otherImg4 {
    width: 40px;
    height: 28px;
  }
  .false {
    color: red;
  }
  .true {
    color: green;
  }
  .pagination{
    float: right;
  }
  .mainTable {
    padding: 5px;
  }
  .v-select >>> label {
    font-size: 14px !important;
    top: 12px !important;
  }
  .v-select >>> fieldset {
    margin-bottom: 20px !important;
    height: 33px !important
  }
  .v-select >>> i {
    margin-bottom: 35px !important;
  }
  .v-select >>> div {
    height: 33px;
    margin-bottom:20px
  }
  .selectedHeaders >>> span {
    margin-top:25px
  }
  .selectedHeaders >>> i {
    margin-top: 75px !important;
  }
  .centered-input >>> input {
    text-align: center;
    height: 30px;
    margin-bottom: 0px !important;
  }
  .centered-input {
    width: 70px;
    margin-top: -6px;
  }
  .search_tab{
    display: flex;
    align-items: center;
    max-width: 1200px;
    margin-left: 30px;
  }
  .logout {
    margin-right: 30px;
    margin-top: 30px;
    float: right;
    background-color: teal !important;
    color: white;
  }
  .setting_btn {
    background-color: teal !important;
    color: white;
    margin-left: 20px;
    margin-top: 13px;
  }
  .filters {
    width: 800px;
    display: flex;
  }
  .addProduct_btn {
    background-color: teal !important;
    color: white;
  }
  .notShow {
    display: none;
  }
</style>
