Vue.createApp({
  mounted() {
    $(this.$refs.prepareForm).on("beforeSubmit", this.prepareMailOut);
    $(this.$refs.sendForm).on("beforeSubmit", this.sendMailOut);
    this.resetPrepareForm();
  },
  data() {
    return {
      mailOut: {
        recipients: "",
        balance: "",
        type: "",
        from: "",
        subject: "",
        message: "",
        attach: "0",
        direct_only: "0",
      },
      previews: {},
      collapsed: false,
      isLoading: false,
    };
  },
  computed: {
    recipients() {
      return this.mailOut.recipients.split(/\r?\n/);
    },
  },
  methods: {
    prepareMailOut(event) {
      event.preventDefault();
      if (this.collapsed === false && $(event.target).find(".has-error").length === 0) {
        this.makeRequest($(event.target).yiiActiveForm("data").options.action, this.mailOut, (response) => {
          this.collapse(event);
          this.previews = {};
          this.mailOut.recipients = response.data.recipients;
        });
      }

      return false;
    },
    sendMailOut(event) {
      event.preventDefault();
      if (confirm(event.target.dataset.confirmMessage)) {
        this.makeRequest($(event.target).yiiActiveForm("data").options.action, this.mailOut, () => {
          this.mailOut.recipients = "";
          this.expand();
          this.resetPrepareForm();
          hipanel.notify.success(event.target.dataset.successMessage);
        });
      }

      return false;
    },
    showPreviewFor(event, recipient) {
      const btn = $(event.target).button("loading");
      const payload = Object.assign({}, this.mailOut);
      payload.recipients = recipient;
      this.makeRequest($("#show-preview-mail-out").data("action"), payload, (response) => {
        for (const [login, data] of Object.entries(response.data)) {
          this.previews[login] = data;
        }
      });
    },
    collapse() {
      this.collapsed = true;
    },
    expand() {
      this.collapsed = false;
      this.mailOut.recipients = "";
    },
    showModal() {
      this.$nextTick(() => {
        $("#show-preview-mail-out").modal("show");
      });
    },
    resetPrepareForm() {
      this.mailOut.balance = "any";
      this.mailOut.type = "invoice";
      this.mailOut.attach = "0";
      this.mailOut.direct_only = "0";
      this.mailOut.from = "";
      this.mailOut.subject = "";
      this.mailOut.message = "";
    },
    makeRequest(url, data, callback) {
      $.ajax({
        url: url,
        method: 'POST',
        timeout: 999999,
        type: "post",
        dataType: "json",
        cache: false,
        data: data,
        beforeSend: () => {
          this.isLoading = true;
        },
        complete: () => {
          this.isLoading = false;
        },
      }).done(function (response) {
        if (response.errorMessage) {
          hipanel.notify.error(response.errorMessage);
        } else {
          if (typeof callback === "function") {
            callback(response);
          }
        }
      }).fail(function () {
        console.log("error");
      });
    },
  },
}).mount("#mail-out-app");
