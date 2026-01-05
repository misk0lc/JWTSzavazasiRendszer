ne legyen kulon a softdelete meg admin a modelben
meglehessen nezni hogy a user mikre szavazott es mivel


{
	"info": {
		"_postman_id": "aec5ff4a-6078-4580-ad02-74245357504b",
		"name": "Szavazási Rendszer API",
		"description": "Bearer tokenes (Sanctum) API a szavazási rendszerhez",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json",
		"_exporter_id": "49287440",
		"_collection_link": "https://misk0lc-2730274.postman.co/workspace/misk0lc's-Workspace~fabc1c87-2e93-428d-8485-c54f928a8754/collection/49287440-aec5ff4a-6078-4580-ad02-74245357504b?action=share&source=collection_link&creator=49287440"
	},
	"item": [
		{
			"name": "Auth",
			"item": [
				{
					"name": "Register",
					"event": [
						{
							"listen": "test",
							"script": {
								"exec": [
									""
								],
								"type": "text/javascript",
								"packages": {},
								"requests": {}
							}
						},
						{
							"listen": "prerequest",
							"script": {
								"exec": [
									""
								],
								"type": "text/javascript",
								"packages": {},
								"requests": {}
							}
						}
					],
					"request": {
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							},
							{
								"key": "Accept",
								"value": "application/json",
								"type": "text"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n  \"name\": \"Teszt Elek\",\n  \"email\": \"teszt@example.com\",\n  \"password\": \"secret123\"\n}"
						},
						"url": {
							"raw": "{{base_url}}/api/register",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"register"
							]
						}
					},
					"response": []
				},
				{
					"name": "Login",
					"event": [
						{
							"listen": "test",
							"script": {
								"exec": [
									"let json = {};",
									"try { json = pm.response.json(); } catch (e) {}",
									"if (json && json.access_token) {",
									"  pm.collectionVariables.set('token', json.access_token);",
									"  pm.test('Token set', function () { pm.expect(pm.collectionVariables.get('token')).to.be.a('string'); });",
									"} else {",
									"  pm.test('Token not found in response', function () { pm.expect.fail('No access_token in response'); });",
									"}"
								],
								"type": "text/javascript"
							}
						}
					],
					"request": {
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n  \"email\": \"teszt@example.com\",\n  \"password\": \"secret123\"\n}"
						},
						"url": {
							"raw": "{{base_url}}/api/login",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"login"
							]
						}
					},
					"response": []
				},
				{
					"name": "Login Admin",
					"event": [
						{
							"listen": "test",
							"script": {
								"exec": [
									"let json = {};",
									"try { ",
									"    json = pm.response.json(); ",
									"} catch (e) {}",
									"",
									"if (json && json.access_token) {",
									"    // Itt történik a mentés az admin_token változóba",
									"    pm.collectionVariables.set('admin_token', json.access_token);",
									"    ",
									"    pm.test('Admin token set', function () { ",
									"        pm.expect(pm.collectionVariables.get('admin_token')).to.be.a('string'); ",
									"    });",
									"} else {",
									"    pm.test('Token not found in response', function () { ",
									"        pm.expect.fail('No access_token in response'); ",
									"    });",
									"}"
								],
								"type": "text/javascript",
								"packages": {},
								"requests": {}
							}
						}
					],
					"request": {
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n  \"email\": \"admin@example.com\",\n  \"password\": \"admin123\"\n}"
						},
						"url": {
							"raw": "{{base_url}}/api/login",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"login"
							]
						}
					},
					"response": []
				},
				{
					"name": "Logout",
					"event": [
						{
							"listen": "test",
							"script": {
								"exec": [
									"pm.test('Status is 200', function () {",
									"  pm.response.to.have.status(200);",
									"});",
									"pm.collectionVariables.set('token', '');"
								],
								"type": "text/javascript"
							}
						}
					],
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"url": {
							"raw": "{{base_url}}/api/logout",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"logout"
							]
						}
					},
					"response": []
				},
				{
					"name": "Admin Logout",
					"event": [
						{
							"listen": "test",
							"script": {
								"exec": [
									"pm.test('Status is 200', function () {",
									"  pm.response.to.have.status(200);",
									"});",
									"pm.collectionVariables.set('token', '');"
								],
								"type": "text/javascript",
								"packages": {},
								"requests": {}
							}
						}
					],
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"url": {
							"raw": "{{base_url}}/api/logout",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"logout"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "Polls (public)",
			"item": [
				{
					"name": "List polls",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{base_url}}/api/polls",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"polls"
							]
						}
					},
					"response": []
				},
				{
					"name": "Show poll",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{base_url}}/api/polls/{{pollId}}",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"polls",
								"{{pollId}}"
							]
						}
					},
					"response": []
				},
				{
					"name": "Results",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{base_url}}/api/polls/{{pollId}}/results",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"polls",
								"{{pollId}}",
								"results"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "Polls (protected)",
			"item": [
				{
					"name": "Create poll",
					"event": [
						{
							"listen": "test",
							"script": {
								"type": "text/javascript",
								"exec": [
									"pm.test('Create poll status is 201', function () { pm.response.to.have.status(201); });",
									"let json = {};",
									"try { json = pm.response.json(); } catch (e) {}",
									"if (json && json.id) {",
									"  pm.collectionVariables.set('pollId', json.id.toString());",
									"  pm.test('pollId saved', function () { pm.expect(pm.collectionVariables.get('pollId')).to.be.a('string'); });",
									"}"
								]
							}
						}
					],
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n  \"question\": \"Tetszik a rendszer?\",\n  \"description\": \"Rövid leírás\",\n  \"options\": [\"Igen\", \"Nem\"],\n  \"closes_at\": null\n}"
						},
						"url": {
							"raw": "{{base_url}}/api/polls",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"polls"
							]
						}
					},
					"response": []
				},
				{
					"name": "Vote",
					"event": [
						{
							"listen": "test",
							"script": {
								"type": "text/javascript",
								"exec": [
									"pm.test('Vote status is 201', function () { pm.response.to.have.status(201); });",
									"let json = {};",
									"try { json = pm.response.json(); } catch (e) {}",
									"pm.test('Response contains message and vote', function () {",
									"  pm.expect(json).to.have.property('message');",
									"  pm.expect(json).to.have.property('vote');",
									"});"
								]
							}
						}
					],
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n  \"selected_option\": \"Igen\"\n}"
						},
						"url": {
							"raw": "{{base_url}}/api/polls/{{pollId}}/vote",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"polls",
								"{{pollId}}",
								"vote"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "Admin",
			"item": [
				{
					"name": "Update poll",
					"event": [
						{
							"listen": "test",
							"script": {
								"type": "text/javascript",
								"exec": [
									"pm.test('Admin update returns 200', function () { pm.response.to.have.status(200); });",
									"let json = {};",
									"try { json = pm.response.json(); } catch (e) {}",
									"pm.test('Response has message', function () { pm.expect(json).to.have.property('message'); });"
								]
							}
						}
					],
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "PUT",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n  \"question\": \"Módosított kérdés?\",\n  \"description\": \"Módosított leírás\",\n  \"options\": [\"Opcio 1\", \"Opcio 2\", \"Opcio 3\"]\n}"
						},
						"url": {
							"raw": "{{base_url}}/api/admin/polls/{{pollId}}",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"{{pollId}}"
							]
						}
					},
					"response": []
				},
				{
					"name": "Delete poll (soft)",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "{{base_url}}/api/admin/polls/{{pollId}}",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"{{pollId}}"
							]
						}
					},
					"response": []
				},
				{
					"name": "Close poll",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"url": {
							"raw": "{{base_url}}/api/admin/polls/{{pollId}}/close",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"{{pollId}}",
								"close"
							]
						}
					},
					"response": []
				},
				{
					"name": "Extend poll",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n  \"closes_at\": \"2025-12-31 23:59:59\"\n}"
						},
						"url": {
							"raw": "{{base_url}}/api/admin/polls/{{pollId}}/extend",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"{{pollId}}",
								"extend"
							]
						}
					},
					"response": []
				},
				{
					"name": "Open poll",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json"
							}
						],
						"url": {
							"raw": "{{base_url}}/api/admin/polls/{{pollId}}/open",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"{{pollId}}",
								"open"
							]
						}
					},
					"response": []
				},
				{
					"name": "List trashed polls",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{base_url}}/api/admin/polls/trashed",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"trashed"
							]
						}
					},
					"response": []
				},
				{
					"name": "Restore poll",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"url": {
							"raw": "{{base_url}}/api/admin/polls/{{pollId}}/restore",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"{{pollId}}",
								"restore"
							]
						}
					},
					"response": []
				},
				{
					"name": "Force delete poll",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{admin_token}}",
									"type": "string"
								}
							]
						},
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "{{base_url}}/api/admin/polls/{{pollId}}/force",
							"host": [
								"{{base_url}}"
							],
							"path": [
								"api",
								"admin",
								"polls",
								"{{pollId}}",
								"force"
							]
						}
					},
					"response": []
				}
			]
		}
	],
	"event": [
		{
			"listen": "prerequest",
			"script": {
				"type": "text/javascript",
				"exec": [
					"// Pre-request script to validate base_url and add debug timestamp",
					"",
					"// 1. Validate that base_url variable exists",
					"const baseUrl = pm.variables.get('base_url');",
					"",
					"if (!baseUrl) {",
					"    throw new Error(\"Pre-request validation failed: 'base_url' variable is not defined. Please set this variable in your environment or collection.\");",
					"}",
					"",
					"// 2. Validate that base_url is a valid URL format",
					"const urlPattern = /^(https?:\\/\\/)[\\.\\w\\-]+(:\\d+)?(\\/.*)?$/i;",
					"if (!urlPattern.test(baseUrl)) {",
					"    throw new Error(\"Pre-request validation failed: 'base_url' value '\" + baseUrl + \"' is not a valid URL. Expected format: http(s)://hostname[:port][/path]\");",
					"}",
					"console.log('✓ base_url validated:', baseUrl);",
					"",
					"// 3. Set X-Debug-Timestamp header with current timestamp",
					"const timestamp = new Date().toISOString();",
					"pm.request.headers.add({",
					"    key: 'X-Debug-Timestamp',",
					"    value: timestamp",
					"});",
					"console.log('✓ X-Debug-Timestamp header set:', timestamp);"
				]
			}
		},
		{
			"listen": "test",
			"script": {
				"type": "text/javascript",
				"exec": [
					"// Post-response script for all requests",
					"",
					"// Test 1: Check response status",
					"pm.test('Status code is in acceptable range', function () {",
					"    pm.expect(pm.response.code).to.be.oneOf([200, 201, 204, 400, 401, 403, 404, 422]);",
					"});",
					"",
					"// Test 2: Check that response has proper content-type",
					"pm.test('Content-Type is application/json', function () {",
					"    if (pm.response.code !== 204) {",
					"        pm.expect(pm.response.headers.get('Content-Type')).to.include('application/json');",
					"    }",
					"});",
					"",
					"// Test 3: Assert response time is less than 2000ms",
					"pm.test('Response time is less than 2000ms', function () {",
					"    pm.expect(pm.response.responseTime).to.be.below(2000, 'Response time was ' + pm.response.responseTime + 'ms, which exceeds the 2000ms threshold');",
					"});",
					"",
					"// Test 4: If status is not 200, log detailed error info",
					"pm.test('No server errors', function () {",
					"    if (pm.response.code >= 500) {",
					"        console.error('=== SERVER ERROR DETECTED ===');",
					"        console.error('Status:', pm.response.code, pm.response.status);",
					"        console.error('Response Headers:', JSON.stringify(pm.response.headers.toObject(), null, 2));",
					"        console.error('Response Body (first 1000 chars):', pm.response.text().substring(0, 1000));",
					"        pm.expect.fail('Server returned error ' + pm.response.code + '. This indicates a server-side issue. Check console for full response details.');",
					"    }",
					"});"
				]
			}
		}
	],
	"variable": [
		{
			"key": "base_url",
			"value": "http://127.0.0.1:8000"
		},
		{
			"key": "pollId",
			"value": "1"
		},
		{
			"key": "token",
			"value": ""
		},
		{
			"key": "admin_token",
			"value": ""
		},
		{
			"key": "test_email",
			"value": ""
		}
	]
}
