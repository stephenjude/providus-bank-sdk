# providus-bank-sdk
This package is used for consuming providus bank apis.

BaseUrl: http://154.113.16.142:8088/appdevapi/api/

Client-Id: dGVzdF9Qcm92aWR1cw==

ClientSecret: 29A492021F4B709A8D1152C3EF4D32DC5A7092723ECAC4C511781003584B48873CCBFEBDEAE89CF22ED1CB1A836213549BC6638A3B563CA7FC009BEB3BC30CF8
(Note: The ClientSecret is not part of the header, its only used to generate the X-Auth-Signature, The Client-Id and X-Auth-Signature is to be used in the header)

For production Kindly generate the x-auth-signature using:
X-Auth-Signature: SHA512(ClientId:ClientSecret)

X-Auth-Signature: BE09BEE831CF262226B426E39BD1092AF84DC63076D4174FAC78A2261F9A3D6E59744983B8326B69CDF2963FE314DFC89635CFA37A40596508DD6EAAB09402C7
