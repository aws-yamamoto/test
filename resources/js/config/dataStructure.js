// データ構造設定ファイル

export default {
  // 店舗マスタ
  store: {
    id: null,
    store_name: '',
    disp_type: null,
    delete_type: false,
    info_items: [],
  },
  // 商品カテゴリマスタ
  productCategory: {
    id: null,
    parent_product_category_id: null,
    name: '',
    subname: '',
    valid_period_from: '',
    valid_period_to: '',
    app_display_type: null,
    edit_status: 'edit',
    disp_type: 1,
    priority_order: null,
    delete_type: false,
    info_items: [],
  },
  // 商品マスタ
  product: {
    id: null,
    product_category_id: null,
    name: '',
    subname: '',
    short_description: '',
    long_description: '',
    unit: '',
    unit_disp: '',
    image: '',
    app_display_type: null,
    valid_period_from: '',
    valid_period_to: '',
    image_name: '',
  },
  // 商品構成マスタ
  productItemStructure: {
    id: null,
    product_id: null,
    name: '',
    subname: '',
    priority_order: null,
    select_type: null,
    select_qty_min: null,
    select_qty_max: null,
    valid_period_from: '',
    valid_period_to: '',
    app_disp_type: null,
    edit_status: '',
    disp_type: null,
    delete_type: false,
    info_items: [],
  },
  // 商品品目マスタ
  productItem: {
    id: null,
    product_item_structure_id: null,
    item_id: null,
    quty_selected_type: null,
    disp_order: null,
    valid_period_from: '',
    valid_period_to: '',
    app_display_type: null,
    edit_status: '',
    disp_type: null,
    delete_type: false,
  },
  // 品目マスタ
  item: {
    id: null,
    name: '',
    subname: '',
    image: '',
    image_name: '',
  },
  // 商品品目分量
  productItemQuantity: {
    id: null,
    product_item_id: null,
    quty_type: null,
    fixed_value_name: '',
    fixed_value: 0,
    disp_order: null,
    unit: '',
    display_unit: '',
    change_value_range: 0,
    change_value_default: 0,
    change_value_min: 0,
    change_value_max: 0,
    selling_price: 0,
    cost: 0,
    energy: 0,
    protein: 0,
    carbohydrate: 0,
    fat: 0,
    salt_equivalent: 0,
    delete_type: false,
  },
  // 時間帯
  orderTimeZone: {
    id: null,
    store_id: null,
    receipt_timezone_from: '',
    receipt_timezone_to: '',
    orderable_number: null,
    enabled: true,
  },
  // 検証端末
  verificationDevice: {
    id: null,
    app_user_id: null,
    verification_date: '',
    is_verification: false,
  },
  // info ポップアップ
  infoItem: {
    id: null,
    info_item_name: '',
    image: '',
  },
  // アプリバージョン
  appVersion: {
    id: null,
    version: '',
    update_date: '',
    remarks: '',
  },
  // ユーザー
  user: {
    id: null,
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  },
}
