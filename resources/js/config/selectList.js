// 汎用セレクトボックス内データ設定ファイル

export default {
  // 表示タイプ
  dispTypeList: [
    {
      id: 1,
      value: '表示',
    },
    {
      id: 2,
      value: '非表示',
    },
    {
      id: 3,
      value: 'プレ表示',
    },
  ],
  // アプリ表示区分
  appDispTypeList: [
    {
      id: 1,
      value: '横幅フル表示',
    },
    {
      id: 2,
      value: '横幅ハーフ表示',
    },
  ],
  // 選択必須
  requiredList: [
    {
      id: 1,
      value: '必須',
    },
    {
      id: 2,
      value: '任意',
    },
  ],
  // 選択方式
  selectTypeList: [
    {
      id: 1,
      value: 'ベース',
    },
    {
      id: 2,
      value: '通常',
    },
  ],
  // 欠品区分
  soldOutTypeList: [
    {
      id: 1,
      value: '欠品',
    },
    {
      id: 2,
      value: '在庫あり',
    },
  ],
  // オーダーステータス
  orderStatusList: [
    {
      id: 1,
      value: '注文済み',
    },
    {
      id: 2,
      value: 'できあがり',
    },
  ],
  // 分量選択方式
  qutySelectedTypeList: [
    {
      id: 1,
      value: '固定値選択',
    },
    {
      id: 2,
      value: '増減',
    },
  ],
  // 有効無効
  enabledTypeList: [
    {
      id: 1,
      value: '有効',
    },
    {
      id: 2,
      value: '無効',
    },
  ],
  // 編集ステータス
  editStatusList: [
    {
      id: 1,
      value: '編集完了',
    },
    {
      id: 2,
      value: '編集中',
    },
  ],
  // ラベル印字接続タイプ
  labelConnectionTypeList: [
    {
      id: 0,
      value: 'WIFI',
    },
    {
      id: 1,
      value: 'BLUETOOTH',
    },
    {
      id: 3,
      value: 'USB',
    },
  ],
}
