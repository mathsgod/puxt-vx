<script setup>
const UserGroup = await vx.$get("/ACL/all?_entry=getUserGroup");
</script>

<template>
  <div>test</div>
  <el-card :header="$t('Permissions')">
    <p>Permission according to roles</p>

    <el-form inline>
      <el-form-item label="User group">
        <el-select v-model="usergroup_id" clearable>
          <el-option
            v-for="ug in UserGroup"
            :value="ug.usergroup_id"
            :label="ug.name"
            :key="ug.usergroup_id"
          >
          </el-option>
        </el-select>
      </el-form-item>

      <el-form-item v-if="usergroup_id">
        <el-button @click="exportXlsx">Export</el-button>
      </el-form-item>
    </el-form>

    <el-table :data="items" stripe>
      <el-table-column type="expand">
        <template slot-scope="props">
          <el-table :data="props.row.files">
            <el-table-column label="Name" prop="name"></el-table-column>
            <el-table-column label="Allow">
              <template slot-scope="scope">
                <el-checkbox
                  v-model="scope.row.allow.checked"
                  :disabled="scope.row.allow.disabled"
                  @input="
                    changePathValue(
                      props.row.name,
                      scope.row.name,
                      'allow',
                      scope.row.allow.checked
                    )
                  "
                >
                </el-checkbox>
              </template>
            </el-table-column>
            <el-table-column label="Deny">
              <template slot-scope="scope">
                <el-checkbox
                  v-model="scope.row.deny.checked"
                  :disabled="scope.row.deny.disabled"
                  @input="
                    changePathValue(
                      props.row.name,
                      scope.row.name,
                      'deny',
                      scope.row.deny.checked
                    )
                  "
                >
                </el-checkbox>
              </template>
            </el-table-column>
          </el-table>
        </template>
      </el-table-column>
      <el-table-column label="Module" prop="name"></el-table-column>
      <el-table-column label="Full Control">
        <template slot-scope="scope">
          <el-checkbox
            v-model="scope.row.all.value"
            :disabled="scope.row.all.disabled"
            @input="changeValue(scope.row.name, 'all')"
          ></el-checkbox>
        </template>
      </el-table-column>
      <el-table-column label="Create">
        <template slot-scope="scope">
          <el-checkbox
            v-model="scope.row.create.value"
            :disabled="scope.row.create.disabled"
            @input="changeValue(scope.row.name, 'create')"
          ></el-checkbox>
        </template>
      </el-table-column>
      <el-table-column label="Read">
        <template slot-scope="scope">
          <el-checkbox
            v-model="scope.row.read.value"
            :disabled="scope.row.read.disabled"
            @input="changeValue(scope.row.name, 'read')"
          ></el-checkbox>
        </template>
      </el-table-column>
      <el-table-column label="Write">
        <template slot-scope="scope">
          <el-checkbox
            v-model="scope.row.update.value"
            :disabled="scope.row.update.disabled"
            @input="changeValue(scope.row.name, 'update')"
          ></el-checkbox>
        </template>
      </el-table-column>
      <el-table-column label="Delete">
        <template slot-scope="scope">
          <el-checkbox
            v-model="scope.row.delete.value"
            :disabled="scope.row.delete.disabled"
            @input="changeValue(scope.row.name, 'delete')"
          ></el-checkbox>
        </template>
      </el-table-column>
    </el-table>
  </el-card>
</template>

<script>
export default {
  data() {
    return {
      usergroup_id: null,
      items: null,
    };
  },
  async created() {
    //    console.log("Test");
    //   this.UserGroup = (await this.$vx.get("/ACL/all?_entry=getUserGroup")).data;
  },
  watch: {
    async usergroup_id() {
      if (!this.usergroup_id) {
        this.items = [];
        return;
      }

      let resp = (
        await this.$vx.get("/ACL/all", {
          params: {
            _entry: "getACL",
            usergroup_id: this.usergroup_id,
          },
        })
      ).data;
      this.items = resp;
    },
  },
  methods: {
    exportXlsx() {
      window.self.location =
        vx.endpoint +
        "ACL/all?usergroup_id=" +
        this.usergroup_id +
        "&_entry=getXlsx&_token=" +
        vx.accessToken;
    },
    async changePathValue(module, path, value, checked) {
      let resp = await this.$vx.post("/ACL/all", {
        usergroup_id: this.usergroup_id,
        module,
        path,
        value,
        checked: checked,
        type: "path",
      });
    },
    async changeValue(module, action) {
      let items = this.items.filter((item) => item.name == module)[0];

      let resp = await this.$vx.post("/ACL/all", {
        usergroup_id: this.usergroup_id,
        module,
        action,
        value: items[action].value,
      });
    },
  },
};
</script>