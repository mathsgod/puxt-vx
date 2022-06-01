<template>
  <div>
    <el-form>
      <el-form-item label="Module">
        <el-select v-model="module" clearable filterable>
          <el-option
            v-for="m in modules"
            :key="m.name"
            :label="m.name"
            :value="m.name"
          ></el-option>
        </el-select>
      </el-form-item>
    </el-form>

    <el-table :data="items" class="mb-1" size="small">
      <el-table-column width="100">
        <template #header>
          <q-btn @click="addItem" dense flat round>
            <q-icon name="add"></q-icon>
          </q-btn>
        </template>
        <template #default="scope">
          <q-btn
            @click="items = items.filter((i) => i != scope.row)"
            dense
            flat
            round
          >
            <q-icon name="remove"></q-icon>
          </q-btn>
        </template>
      </el-table-column>
      <el-table-column label="Name" v-slot="scope">
        <el-input v-model="scope.row.name"></el-input>
      </el-table-column>

      <el-table-column v-slot="scope" label="Value">
        <el-table :data="scope.row.value" :show-header="false">
          <el-table-column v-slot="lang">
            <el-tooltip
              effect="dark"
              :content="lang.row.language"
              placement="top-start"
            >
              <el-input
                v-model="lang.row.value"
                :placeHolder="lang.row.language"
              >
              </el-input>
            </el-tooltip>
          </el-table-column>
        </el-table>
      </el-table-column>
    </el-table>
    <el-button @click="save" type="primary" icon="el-icon-check"
      >Save</el-button
    >
  </div>
</template>

<script>
export default {
  data() {
    return {
      modules: [],
      module: null,
      items: [],
      languages: [],
    };
  },
  async created() {
    let { data } = await vx.get("Translate/index?_entry=getData");
    this.modules = data.modules;
    this.languages = data.languages;
  },
  mounted() {
    this.module = "";
  },
  watch: {
    async module() {
      let { data } = await vx.get("Translate/index?_entry=getTranslate", {
        params: {
          module: this.module,
        },
      });
      this.items = data;
    },
  },
  methods: {
    addItem() {
      let t = [];
      for (let l of this.languages) {
        t.push({
          language: l,
          value: "",
        });
      }
      this.items.push({
        name: "",
        value: t,
      });
    },
    async save() {
      await this.$vx.post("Translate/index", {
        module: this.module,
        items: this.items,
      });

      this.$message("Updated", { type: "success" });
    },
  },
};
</script>