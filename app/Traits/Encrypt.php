<?php
namespace App\Traits;

trait Encrypt
{
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->getEncrypts() as $key) {
            if (array_key_exists($key, $attributes) && $attributes[$key]) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }
        return $attributes;
    }

    /**
     * 復号化
     */
    public function getAttributeValue($key)
    {
        if (in_array($key, $this->getEncrypts())) {
            try {
                return decrypt($this->attributes[$key]);
            } catch (\Exception $e) {
                return $this->attributes[$key];
            }
        }
        return parent::getAttributeValue($key);
    }

    /**
     * 暗号化
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getEncrypts())) {
            $this->attributes[$key] = encrypt($value);
        } else {
            parent::setAttribute($key, $value);
        }
        return $this;
    }

    /**
     * 暗号化するkeyを取得
     *
     * @return array
     */
    protected function getEncrypts()
    {
        return property_exists($this, 'encrypts') ? $this->encrypts : [];
    }

    /**
     * 暗号化カラムの検索処理
     *
     * @param string $keyword 検索する文字列
     * @param array $columns 検索に必要なカラム
     * @param array $searchKeywords 検索対象のカラム
     */
    public function searchKeyword($keyword, $columns, $searchKeywords)
    {
        $records = $this->get($columns);

        $results = [];
        foreach ($records as $record) {
            if ($keyword) {
                foreach ($searchKeywords as $searchKeyword) {
                    if (strpos($record[$searchKeyword], $keyword) !== false) {
                        $results[] = $record['id'];
                    }
                }
            } else {
                $results[] = $record['id'];
            }
        }

        return $results;
    }
}
