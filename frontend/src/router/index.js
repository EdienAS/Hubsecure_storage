import Vue from "vue";
import VueRouter from "vue-router";
import store from "@/store";

Vue.use(VueRouter);

const routes = [
  // Dashboard Layout
  {
    path: "/",
    name: "",
    meta: { requiresAuth: true },
    component: () => import("@/layouts/WithSidebar"),
    children: [
      // {
      //   path: "share/:token",
      //   name: "drive.foldershareview",
      //   meta: { name: "foldershareview" },
      //   component: () => import("@/views/backend/MyDrive/FolderShareView"),
      // },
      {
        path: "",
        name: "layout.dashboard",
        meta: { name: "Dashboard" },
        component: () => import("@/views/backend/Dashboards/Dashboard"),
      },
      {
        path: "files",
        name: "layout.files",
        meta: { name: "Files" },
        component: () => import("@/views/backend/CloudBox/Files"),
      },
      {
        path: "recent",
        name: "layout.recent",
        meta: { name: "Recent" },
        component: () => import("@/views/backend/CloudBox/Recent"),
      },
      {
        path: "favourite",
        name: "layout.favourite",
        meta: { name: "favourite" },
        component: () => import("@/views/backend/CloudBox/Favourite"),
      },
      {
        path: "trash",
        name: "layout.trash",
        meta: { name: "trash" },
        component: () => import("@/views/backend/CloudBox/Trash"),
      },
      {
        path: "my-drive",
        name: "drive.filebrowser",
        meta: { name: "filebrowser" },
        component: () => import("@/views/backend/MyDrive/FileBrowser"),
      },
      {
        path: "my-drive/:uuid",
        name: "drive.filebrowserdetail",
        meta: { name: "filebrowserdetail" },
        component: () => import("@/views/backend/MyDrive/FileBrowserDetail"),
      },
      {
        path: "android",
        name: "drive.android",
        meta: { name: "android" },
        component: () => import("@/views/backend/MyDrive/Android"),
      },
      {
        path: "brightspot",
        name: "drive.brightspot",
        meta: { name: "brightspot" },
        component: () => import("@/views/backend/MyDrive/Brightspot"),
      },
      {
        path: "ionic-chat-app",
        name: "drive.ionic-chat-app",
        meta: { name: "ionic chat app" },
        component: () => import("@/views/backend/MyDrive/IonicChatApp"),
      },
      {
        path: "widget-simple",
        name: "widget.simple",
        meta: { name: "Widget Simple" },
        component: () => import("@/views/backend/Widgets/WidgetSimple"),
      },
      {
        path: "widget-chart",
        name: "widget.chart",
        meta: { name: "Widget Chart" },
        component: () => import("@/views/backend/Widgets/WidgetChart"),
      },
      {
        path: "ui-avatars",
        name: "Ui.avatars",
        meta: { name: "Ui Avatars" },
        component: () => import("@/views/backend/Ui/UiAvatars"),
      },
      {
        path: "ui-alert",
        name: "Ui.alerts",
        meta: { name: "Ui Alert" },
        component: () => import("@/views/backend/Ui/UiAlerts"),
      },
      {
        path: "ui-badges",
        name: "Ui.badges",
        meta: { name: "Ui Badges" },
        component: () => import("@/views/backend/Ui/UiBadges"),
      },
      {
        path: "ui-boxshadows",
        name: "Ui.boxshadows",
        meta: { name: "Ui Box Shadows" },
        component: () => import("@/views/backend/Ui/UiBoxShadows"),
      },
      {
        path: "ui-breadcrumbs",
        name: "Ui.breadcrumbs",
        meta: { name: "Ui Breadcrumbs" },
        component: () => import("@/views/backend/Ui/UiBreadcrumbs"),
      },
      {
        path: "ui-button-groups",
        name: "Ui.button-groups",
        meta: { name: "Ui Button Groups" },
        component: () => import("@/views/backend/Ui/UiButtonGroups"),
      },
      {
        path: "ui-buttons",
        name: "Ui.buttons",
        meta: { name: "Ui Buttons" },
        component: () => import("@/views/backend/Ui/UiButtons"),
      },
      {
        path: "ui-cards",
        name: "Ui.cards",
        meta: { name: "Ui Cards" },
        component: () => import("@/views/backend/Ui/UiCards"),
      },
      {
        path: "ui-carousels",
        name: "Ui.carousels",
        meta: { name: "Ui Carousels" },
        component: () => import("@/views/backend/Ui/UiCarousels"),
      },
      {
        path: "ui-colors",
        name: "Ui.colors",
        meta: { name: "Ui Colors" },
        component: () => import("@/views/backend/Ui/UiColors"),
      },
      {
        path: "ui-embed-videos",
        name: "Ui.Embed-videos",
        meta: { name: "Ui Embed" },
        component: () => import("@/views/backend/Ui/UiEmbed"),
      },
      {
        path: "ui-grids",
        name: "Ui.grids",
        meta: { name: "Ui Grids" },
        component: () => import("@/views/backend/Ui/UiGrids"),
      },
      {
        path: "ui-helper-classes",
        name: "Ui.helper-classes",
        meta: { name: "Ui Helper Classes" },
        component: () => import("@/views/backend/Ui/UiHelperClasses"),
      },
      {
        path: "ui-images",
        name: "Ui.images",
        meta: { name: "Ui Images" },
        component: () => import("@/views/backend/Ui/UiImages"),
      },
      {
        path: "ui-list-groups",
        name: "Ui.list-groups",
        meta: { name: "Ui List Groups" },
        component: () => import("@/views/backend/Ui/UiListGroups"),
      },
      {
        path: "ui-media-objects",
        name: "Ui.media-objects",
        meta: { name: "Ui Media Objects" },
        component: () => import("@/views/backend/Ui/UiMediaObjects"),
      },
      {
        path: "ui-modals",
        name: "Ui.modals",
        meta: { name: "Ui Modals" },
        component: () => import("@/views/backend/Ui/UiModals"),
      },
      {
        path: "ui-notifications",
        name: "Ui.notifications",
        meta: { name: "Ui Notifications" },
        component: () => import("@/views/backend/Ui/UiNotifications"),
      },
      {
        path: "ui-paginations",
        name: "Ui.paginations",
        meta: { name: "Ui Pagination" },
        component: () => import("@/views/backend/Ui/UiPaginations"),
      },
      {
        path: "ui-popovers",
        name: "Ui.popovers",
        meta: { name: "Ui popovers" },
        component: () => import("@/views/backend/Ui/UiPopOvers"),
      },
      {
        path: "ui-progressbars",
        name: "Ui.progressbars",
        meta: { name: "Ui Progressbar" },
        component: () => import("@/views/backend/Ui/UiProgressBars"),
      },
      {
        path: "ui-tabs",
        name: "Ui.tabs",
        meta: { name: "Ui Tabs" },
        component: () => import("@/views/backend/Ui/UiTabs"),
      },
      {
        path: "ui-tooltips",
        name: "Ui.tooltips",
        meta: { name: "Ui Tooltips" },
        component: () => import("@/views/backend/Ui/UiTooltips"),
      },
      {
        path: "ui-typography",
        name: "Ui.typographys",
        meta: { name: "Ui Typography" },
        component: () => import("@/views/backend/Ui/UiTypography"),
      },
      {
        path: "form-checkbox",
        name: "controls.form-checkbox",
        meta: { name: "Form Checkbox" },
        component: () => import("@/views/backend/Forms/Form Controls/Checkbox"),
      },
      {
        path: "form-layouts",
        name: "controls.form-layout",
        meta: { name: "Form Layouts" },
        component: () => import("@/views/backend/Forms/Form Controls/Elements"),
      },
      {
        path: "form-input",
        name: "controls.form-input",
        meta: { name: "Form Input" },
        component: () => import("@/views/backend/Forms/Form Controls/Inputs"),
      },
      {
        path: "form-radio",
        name: "controls.form-radio",
        meta: { name: "Form Radio" },
        component: () => import("@/views/backend/Forms/Form Controls/Radio"),
      },
      {
        path: "form-switch",
        name: "controls.form-switch",
        meta: { name: "Form Switch" },
        component: () => import("@/views/backend/Forms/Form Controls/Switch"),
      },
      {
        path: "form-textarea",
        name: "controls.form-textarea",
        meta: { name: "Form TextArea" },
        component: () => import("@/views/backend/Forms/Form Controls/TextArea"),
      },
      {
        path: "form-validation",
        name: "controls.form-validation",
        meta: { name: "Form Validation" },
        component: () => import("@/views/backend/Forms/Form Controls/Validations"),
      },
      {
        path: "form-datepicker",
        name: "widget.form-datepicker",
        meta: { name: "Form Datepicker" },
        component: () => import("@/views/backend/Forms/Form widget/Datepicker"),
      },
      {
        path: "form-file-uploader",
        name: "widget.form-file-uploader",
        meta: { name: "Form Fileupload" },
        component: () => import("@/views/backend/Forms/Form widget/Fileupload"),
      },
      {
        path: "form-quill",
        name: "widget.form-quill",
        meta: { name: "Form quill" },
        component: () => import("@/views/backend/Forms/Form widget/FormQuill"),
      },
      {
        path: "form-select",
        name: "widget.form-select",
        meta: { name: "Form Select2" },
        component: () => import("@/views/backend/Forms/Form widget/SelectComponents"),
      },
      {
        path: "form-wizard",
        name: "wizard.form-wizard",
        meta: { name: "Form Wizard" },
        component: () => import("@/views/backend/Forms/Form Wizard/Simple"),
      },
      {
        path: "form-wizard-validate",
        name: "wizard.form-wizard-validate",
        meta: { name: "Form Wizard Validate" },
        component: () => import("@/views/backend/Forms/Form Wizard/Validate"),
      },
      {
        path: "form-wizard-vertical",
        name: "wizard.form-wizard-vertical",
        meta: { name: "Form Wizard Vertical" },
        component: () => import("@/views/backend/Forms/Form Wizard/Vertical"),
      },
      {
        path: "basic-table",
        name: "table.basic-table",
        meta: { name: "Basic Table " },
        component: () => import("@/views/backend/Table/BasicTable"),
      },
      {
        path: "data-table",
        name: "table.data-table",
        meta: { name: "Data Table " },
        component: () => import("@/views/backend/Table/DataTable"),
      },
      {
        path: "edit-table",
        name: "table.edit-table",
        meta: { name: "Edit Table " },
        component: () => import("@/views/backend/Table/EditTable"),
      },
      {
        path: "icon-dripicons",
        name: "icon.dripicon",
        meta: { name: "Dripicons " },
        component: () => import("@/views/backend/Icons/Dripicons"),
      },
      {
        path: "icon-fontawsome",
        name: "icon.fontawsome",
        meta: { name: "FontAwsome " },
        component: () => import("@/views/backend/Icons/FontAwsome"),
      },
      {
        path: "icon-lineawsome",
        name: "icon.lineawsome",
        meta: { name: "LineAwsome " },
        component: () => import("@/views/backend/Icons/LineAwsome"),
      },
      {
        path: "icon-remixicon",
        name: "icon.remixicon",
        meta: { name: "Remixicon " },
        component: () => import("@/views/backend/Icons/Remixicons"),
      },
      {
        path: "am-chart",
        name: "chart.amchart",
        meta: { name: "Amchart" },
        component: () => import("@/views/backend/Chart/AmChart"),
      },
      {
        path: "apex-chart",
        name: "chart.apexchart",
        meta: { name: "Apexchart" },
        component: () => import("@/views/backend/Chart/ApexChart"),
      },
      {
        path: "high-chart",
        name: "chart.highchart",
        meta: { name: "Highchart" },
        component: () => import("@/views/backend/Chart/HighChart"),
      },
      {
        path: "morris-chart",
        name: "chart.morrischart",
        meta: { name: "Morrischart" },
        component: () => import("@/views/backend/Chart/MorrisChart"),
      },
      {
        path: "user-add",
        name: "app.user-add",
        meta: { name: "user-add" },
        component: () => import("@/views/backend/App/User Management/UserAdd"),
      },
      {
        path: "user-list",
        name: "app.user-list",
        meta: { name: "User Add" },
        component: () => import("@/views/backend/App/User Management/UserList"),
      },
      {
        path: "user-profile",
        name: "app.user-profile",
        meta: { name: "User Profile" },
        component: () => import("@/views/backend/App/User Management/UserProfile"),
      },
      {
        path: "email-composes",
        name: "app.email-composes",
        meta: { name: "email-compose" },
        component: () => import("@/views/backend/App/Mail/EmailComposes"),
      },
      {
        path: "email-listing",
        name: "app.email-listing",
        meta: { name: "email listing" },
        component: () => import("@/views/backend/App/Mail/EmailListing"),
      },
      {
        path: "user-privacy-settings",
        name: "app.user-privacy-setting",
        meta: { name: "user-privacy-setting" },
        component: () => import("@/views/backend/App/User Management/UserPrivacySetting"),
      },
      {
        path: "User-profile-edit",
        name: "app.user-profile-edit",
        meta: { name: "user-profile-edit" },
        component: () => import("@/views/backend/App/User Management/UserProfileEdit"),
      },
      {
        path: "User-account-setting",
        name: "app.user-Account-setting",
        meta: { name: "user account setting" },
        component: () => import("@/views/backend/App/User Management/UserAccountSetting"),
      },
      {
        path: "chat",
        name: "app.chat",
        meta: { name: "Chat" },
        component: () => import("@/views/backend/App/Chat"),
      },
      {
        path: "todo",
        name: "app.todo",
        meta: { name: "Todo" },
        component: () => import("@/views/backend/App/Todo"),
      },
      {
        path: "privacy-settings",
        name: "app.Privacysettings",
        meta: { name: "Privacysettings" },
        component: () => import("@/views/backend/App/Extraap/PrivacySettings"),
      },
      {
        path: "terms-of-use",
        name: "app.Termsofuse",
        meta: { name: "Termsofuse" },
        component: () => import("@/views/backend/App/Extraap/TermsOfUse"),
      },
      {
        path: "privacy-policy",
        name: "app.privacypolicy",
        meta: { name: "privacypolicy" },
        component: () => import("@/views/backend/App/Extraap/PrivacyPolicy"),
      },
      {
        path: "account-setting",
        name: "app.Accountsetting",
        meta: { name: "Accountsetting" },
        component: () => import("@/views/backend/App/Extraap/AccountSettings"),
      },
    ],
  },
  // Auth Pages
  {
    path: "/auth",
    name: "auth",
    component: () => import("@/layouts/BlankLayout"),
    children: [
      {
        path: "sign-up",
        name: "auth.register",
        meta: { name: "SignUp" },
        component: () => import("@/views/backend/Auth/SignUp"),
      },
      {
        path: "sign-in",
        name: "auth.login",
        meta: { name: "SignIn" },
        component: () => import("@/views/backend/Auth/SignIn"),
      },
      {
        path: "recover-password",
        name: "auth.recover-password",
        meta: { name: "Recover Password", requiresAuth: true },
        component: () => import("@/views/backend/Auth/RecoverPassword"),
      },
      {
        path: "lock-screen",
        name: "auth.lock-screen",
        meta: { name: "Lock Screen", requiresAuth: true },
        component: () => import("@/views/backend/Auth/LockScreen"),
      },
      {
        path: "confirm-mail",
        name: "auth.confirm-mail",
        meta: { name: "Confirm Mail" },
        component: () => import("@/views/backend/Auth/ConfirmMail"),
      },
    ],
  },
  // Pages
  {
    path: "/pages",
    name: "pages",
    component: () => import("@/layouts/BlankLayout"),
    children: [
      {
        path: "share/:token",
        name: "drive.foldershareview",
        meta: { name: "foldershareview" },
        component: () => import("@/views/backend/MyDrive/FolderShareView"),
      },
      {
        path: "error-404",
        name: "error.404",
        meta: { name: "Error 404" },
        component: () => import("@/views/backend/Pages/Error/Error404"),
      },
      {
        path: "error-500",
        name: "error.500",
        meta: { name: "Error 500" },
        component: () => import("@/views/backend/Pages/Error/Error500"),
      },
      {
        path: "pages-maintainance",
        name: "pages.maintenance",
        meta: { name: "Maintaiance" },
        component: () => import("@/views/backend/Pages/Maintainance"),
      },
      {
        path: "pages-commingsoon",
        name: "pages.commingsoon",
        meta: { name: "Comming Soon" },
        component: () => import("@/views/backend/Pages/CommingSoon"),
      },
    ],
  },
  // Extra Pages
  {
    path: "/extra-pages",
    name: "extra-pages",
    component: () => import("@/layouts/WithSidebar"),
    children: [
      {
        path: "contact-detail",
        name: "contact.detail",
        meta: { name: "Contact Detail" },
        component: () => import("@/views/backend/Pages/Contact/ContactDetails"),
      },
      {
        path: "contact-list",
        name: "contact.list",
        meta: { name: "Contact List" },
        component: () => import("@/views/backend/Pages/Contact/ContactList"),
      },
      {
        path: "timeline-1",
        name: "time.line",
        meta: { name: "TimeLine-1" },
        component: () => import("@/views/backend/Pages/Timeline/Timeline1"),
      },
      {
        path: "timeline-2",
        name: "time.line1",
        meta: { name: "TimeLine-2" },
        component: () => import("@/views/backend/Pages/Timeline/Timeline2"),
      },
      {
        path: "timeline-3",
        name: "time.line2",
        meta: { name: "TimeLine-3" },
        component: () => import("@/views/backend/Pages/Timeline/Timeline3"),
      },
      {
        path: "timeline-4",
        name: "time.line3",
        meta: { name: "TimeLine-4" },
        component: () => import("@/views/backend/Pages/Timeline/Timeline4"),
      },
      {
        path: "pricing-1",
        name: "price.pay",
        meta: { name: "Pricing-1" },
        component: () => import("@/views/backend/Pages/Pricing/Pricing1"),
      },
      {
        path: "pricing-2",
        name: "price.pay1",
        meta: { name: "Pricing-2" },
        component: () => import("@/views/backend/Pages/Pricing/Pricing2"),
      },
      {
        path: "pricing-3",
        name: "price.pay2",
        meta: { name: "Pricing-3" },
        component: () => import("@/views/backend/Pages/Pricing/Pricing3"),
      },
      {
        path: "pricing-4",
        name: "price.pay3",
        meta: { name: "Pricing-4" },
        component: () => import("@/views/backend/Pages/Pricing/Pricing4"),
      },
      {
        path: "pages-invoice",
        name: "pages.invoices",
        meta: { name: "Pages Invoice" },
        component: () => import("@/views/backend/Pages/Invoice"),
      },
      {
        path: "pages-subscriber",
        name: "pages.subscribers",
        meta: { name: "Pages Subscribers" },
        component: () => import("@/views/backend/Pages/Subsribers"),
      },
      {
        path: "pages-faq",
        name: "pages.faq",
        meta: { name: "Pages FAQ" },
        component: () => import("@/views/backend/Pages/FAQ"),
      },
      {
        path: "pages-blank-page",
        name: "pages.blank-page",
        meta: { name: "Pages Blank Page " },
        component: () => import("@/views/backend/Pages/BlankPage"),
      },
    ],
  },
  // make sure the wildcard route is defined last
  { path: "*", redirect: "/pages/error-404" },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.VUE_APP_BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((route) => route.meta && route.meta.requiresAuth)) {
    if (store.getters["Auth/getCompToken"] === null && to.path !== "/auth/sign-in") {
      next({ name: "auth.login" });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
