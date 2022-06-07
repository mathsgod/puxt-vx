<template>
  <div class="row q-col-gutter-lg" v-if="user">
    <div class="col-12 col-lg-6">
      <q-card flat bordered>
        <q-card-section>
          <el-descriptions :title="$t('User Info')" :column="1">
            <el-descriptions-item :label="$t('First name')">{{
              user.first_name
            }}</el-descriptions-item>
            <el-descriptions-item :label="$t('Last name')">{{
              user.last_name
            }}</el-descriptions-item>
            <el-descriptions-item :label="$t('Email')">{{
              user.email
            }}</el-descriptions-item>
            <el-descriptions-item :label="$t('Phone')">{{
              user.phone
            }}</el-descriptions-item>

            <el-descriptions-item :label="$t('Roles')">
              <el-tag
                size="small"
                v-for="(ug, index) in user.UserGroups"
                :key="index"
                >{{ ug.name }}</el-tag
              >
            </el-descriptions-item>
          </el-descriptions>
        </q-card-section>
      </q-card>
    </div>

    <div class="col-12 col-lg-6">
      <q-card flat bordered>
        <q-card-section>
          <el-timeline>
            <el-timeline-item
              v-for="(tl, index) in user.timeline"
              :key="index"
              :timestamp="tl.timestamp"
            >
              {{ tl.content }}
            </el-timeline-item>
          </el-timeline>
        </q-card-section>
      </q-card>
    </div>

    <div class="col-12 col-lg-6">
      <el-table :data="user._userlog">
        <el-table-column label="Login time" prop="login_dt"></el-table-column>
        <el-table-column label="Logout time" prop="logout_dt"></el-table-column>
        <el-table-column label="IP address" prop="ip"></el-table-column>
        <el-table-column label="Result" prop="result"></el-table-column>
      </el-table>
    </div>

    <div class="col-12 col-lg-6">
      <q-card flat bordered>
        <el-table :data="user.permission" stripe>
          <el-table-column label="Module" prop="name"></el-table-column>
          <el-table-column label="Create" #default="scope">
            <el-checkbox disabled v-model="scope.row.create"></el-checkbox>
          </el-table-column>
          <el-table-column label="Read" #default="scope">
            <el-checkbox disabled v-model="scope.row.read"></el-checkbox>
          </el-table-column>
          <el-table-column label="Update" #default="scope">
            <el-checkbox disabled v-model="scope.row.update"></el-checkbox>
          </el-table-column>
          <el-table-column label="Delete" #default="scope">
            <el-checkbox disabled v-model="scope.row.delete"></el-checkbox>
          </el-table-column>
        </el-table>
      </q-card>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: null,
    };
  },
  created() {
    this.fetchUser();
  },
  methods: {
    async fetchUser() {
      const { data } = await vx.get("view?_entry=getData");
      this.user = data.user;
    },
  },
};
</script>