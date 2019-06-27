<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2018100861585640",

    //商户私钥，您的原始格式RSA私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEA1poYENBC4vtZPDXa/zqcGAqkJ7lZJiXg3w9W2QDRfBAmpz259RSKvsJbWQoLFBHdfP6kUqHX3VWvN4S2v5CogQqHG8YiAoUCDHTw+qY7cJGE8QNbw98Vp03zYh/W1nk49qrgjbebx4u94cKnKfB/L8cpLLH73JxjLLSPMyeXpVXzV8EwWWRXVWYQFLxqyLI7L7Lc17tgYv3JzrXAgu0vFLyYF9T9cn7uUvwKPZ/oHvsdAUgY/Bbds7bfhBIBBnShV0AS+msaiDM7jOIG63GsFiIGatK0NkZspWs+pDQEuevnx/IN2QzEmm1ZwEYQjd+o4Rwc4+sKvjkUUugYowWHowIDAQABAoIBAB3qfVBat/hMcbQjDdRmpzvyv8+J1xOqVB7EVKcLpihVWA4YXMP9iRnuni1baQ/zLZ0vIlkilqUUPMjQh2lNETBr90m35SXUxORXqQBIDCE1KAMxJKm5f5tDEpqrNZfQblB0obkfz2eR43aFXChMjm5qpSLF7QZkBq9EvHG1Iz646y+r/lC4hoASKbAJe6clEugad92OnbJUVtryeWUeWH4YYIM2JneBFOoLQu4lMvhDq3xKAO4cuunOTirduTSBu21hnY+mKV7cBjZ1UuRhiZCqtcdebcERF7cRoE33iQqPdxWjY12z9Z9f1pT0X4yoveHONEehH+WRjbCOy0202wECgYEA9+FylEuIHZXn7VgqLOSJJUwDP3G+3Emf2P1JlPtcVUW/cEye5UtbAV/QuYGY42Je2JdWQaSlEeE+sNV1NoDlFLOb6HC+Vu8myFJQO+/QKbDiob4Xyl49nnwgzJhvPK3aFViE+5n6F4NDy8e1XCNS34/x4FByaTwcXkLETtUc3qsCgYEA3aGYMXEzAB6+3vnni+JYxpzsJB9qfcu/a66jpF4aG9BPPXADKUFhcrDPfcC7N+sNJJVHjSOAyWW2uduPrN55ImiLM3gV3s4/3dz+BzyD+godlmG9db0qof7irFdRXNYH6ZsRzoRcHC84LsoUY6/PSwn9O4QTi1orajws3vlkmukCgYEA26FyOFtEW5J7UR0RIX3M1rMnHYvXJLBHZafnDo45HYUTPpllIJ1IIUuYUQW3RaHfj+Fnl/oeGF2Pgndfx88lKtaJicZ7n+N+ZXgphzHRK1+DLvSTd8dQqaAqH53g0c7osIkiKxwfL74qz+A/nUffIh8UnUAqX3vXVt2pun+xeMkCgYBUZUCLM0v0c8DDL+6YOe0MVJ0ndD8dAAU4gBwYby0KAlzqTEkn4Jm3DtU0Ubv5IyyyDZZdjHNyPaVDSPSBI4aFL8IyKzxIx8lSNuEU6FppUIjLxxRaTVp6rZCrh+SXsXj53+778TMSGHkQeCsjesM5E+i2TSkUG5YEsj1z+wvwYQKBgF3VkcF8moHoPoltDhxfO+Cxd8riUXreJZx+Ejzxos+p/KWbDTGaTJAPPsIboWJPybZYlEFcY/BwoT13fa1kgBnctdpw3KuPhT2vN4rY8aPumPx5HZ7PUUDRuJ9jiE+uxnJzz9gD8pFTD7gS7PpKKCL9khbF0LwL2lTwSwQtk2Aj",
    
    //异步通知地址
    'notify_url' => "https://houtai.sdyh.top/api/alipay_notify",
    
    //同步跳转
    'return_url' => "https://houtai.sdyh.top/api/alipay_return",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnTKu89jYZ/9ISvJcSkvpyv6a/tUdAzjyae2UyJXSNpvtt77waoGiM9AeLBYP3fCy/AVbtsMoHW2OsXKSQvYN9aZ43X/4A6uYb6zdLtbum0Jh1y90doNMSuCCHaTKYPpeQ1MeaXfFXZ9d0QnyQobbtJQMhNKmXsdTA/8g0rBP/ZC775MHg4ghMsgXSjoFn6ckB6UrWxtkufkjTLBtxQuf+2GGqzpf7c+iNeFOU+m0vVrK+UkOQFG4T4dSWutCR89s0WTMpxOTrV2mZ79maBeitgj51zx8d6g/wpMi+Dtur9kd+K5UUSfC6TcWveWq19uf37MH4AUORRGHODinGdMcdQIDAQAB",
];