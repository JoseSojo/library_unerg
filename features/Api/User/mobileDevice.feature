Feature: User mobile devices
    In order to test ApiMobileDeviceController

    Background:
        Given a global client with "test@example.com"
        Given I am logged in api as oauth2 "test@example.com"

    Scenario: Registro de dispositivo sin version de la app
        And I add the request parameters:
            | deviceId  | 7c8590825f688f6c992313cb463b3ca3 |
            | expand    | mobile_device.id,mobile_device.type,mobile_device.device_id,mobile_device.os_version,mobile_device.model,mobile_device.device_info,mobile_device.register_id,mobile_device.app_version |
        And I add the request data:
            """
            {
                "form_user_mobile_device": {
                    "type": "App\\Entity\\M\\User\\MobileDevice__TYPE_ANDROID",
                    "deviceId": "7c8590825f688f6c992313cb463b3ca3",
                    "osVersion": "4.0.4",
                    "model": "i9500",
                    "deviceInfo": "Samsung",
                    "registerId": "434354c822af624477f4c61088ebbd4c",
                    "dataRegister": "1",
                    "appVersion": "1"
                }
            }
            """
        When I request "POST /api/user/mobile-device/register.json"
        Then the response status code is 200
        # And the response has a "id,type,device_id,os_version,model,device_info,register_id" properties
        # And the response has a "type" property and it is equals "App\Entity\M\User\MobileDevice__TYPE_ANDROID"

    Scenario: Registro de dispositivo con version de la app
        And I add the request parameters:
            | deviceId  | 7c8590825f688f6c992313cb463b3ca3 |
            | expand    | mobile_device.id,mobile_device.type,mobile_device.device_id,mobile_device.os_version,mobile_device.model,mobile_device.device_info,mobile_device.register_id,mobile_device.app_version |
        And I add the request data:
            """
            {
                "form_user_mobile_device": {
                    "type": "App\\Entity\\M\\User\\MobileDevice__TYPE_IOS",
                    "deviceId": "7c8590825f688f6c992313cb463b3ca3",
                    "osVersion": "4.0.4",
                    "model": "i9500",
                    "deviceInfo": "Samsung",
                    "registerId": "434354c822af624477f4c61088ebbd4c",
                    "appVersion": "2.0.1"
                }
            }
            """
        When I request "POST /api/user/mobile-device/register.json"
        Then the response status code is 200
        # And the response has a "id,type,device_id,os_version,model,device_info,register_id,app_version" properties
        # And the response has a "type" property and it is equals "App\Entity\M\User\MobileDevice__TYPE_IOS"
        # And the response has a "app_version" property and it is equals "2.0.1"

    Scenario: Success unregister a mobile device
        And I add the request data:
            """
            {
                "form_user_mobile_device": {
                    "type": "100",
                    "deviceId": "7c8590825f688f6c992313cb463b3ca3",
                    "osVersion": "4.0.4",
                    "model": "i9500",
                    "deviceInfo": "Samsung",
                    "registerId": "434354c822af624477f4c61088ebbd4c"
                }
            }
            """
        When I request "POST /api/user/mobile-device/register.json"
        Then the response status code is 200
        And I add the request parameters:
            | deviceId  | 7c8590825f688f6c992313cb463b3ca3 |
        When I request "GET /api/user/mobile-device/unregister.json"
        Then the response status code is 200

    Scenario: Error unregister a mobile device
        And I add the request parameters:
            | deviceId  | invalid |
        When I request "GET /api/user/mobile-device/unregister.json"
        Then the response status code is 204