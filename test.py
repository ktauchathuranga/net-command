import requests

# URL of your API endpoint
url = 'http://localhost:8080/api/command'

# JWT token obtained from login (replace this with the actual token you got)
jwt_token = 'YOUR_JWT_TOKEN'

# Data to send in the POST request
data = {
    'readstate': 1
}

# Headers with Authorization Bearer token
headers = {
    'Authorization': f'Bearer {jwt_token}'
}

# Sending the POST request with the Authorization header and data
response = requests.post(url, headers=headers, data=data)

# Check if the request was successful
if response.status_code == 200:
    print("Response:", response.text)
else:
    print(f"Failed to authenticate. Status code: {response.status_code}")
    print("Response:", response.text)
