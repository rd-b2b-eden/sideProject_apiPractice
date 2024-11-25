# 功能需求
*  API 開發
寫三支功能類似的 API，接收相同的請求格式：  
json request  
```json
{
  "count": 5,
  "uuid": "asdf"
}
```
API 的功能為：根據 count 的數值，隨機生成並儲存相應數量的資料到資料庫。例如：count = 100 時，應產生並存入 100 筆隨機資料至資料庫。  
每筆資料儲存進 DB 前要先 sleep 1 秒。
*  實作方式  
每支 API 使用不同的技術實現：  
    *  Commands
    *  Jobs
    *  Event + Listener
*  技術分析  
完成實作後，整理這三種方法的優缺點，並分析其適用時機。將結果整理成一份報告，便於日後與團隊分享。  
