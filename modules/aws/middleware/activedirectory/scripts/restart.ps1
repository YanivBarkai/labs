$OrganizationalUnit = "triplec"
$Domain = "cyber"
$DomainEnding = "com"

$UserInfoToFile = @" 
Local Accounts:
Cyber   Cyber
Admin   admin  
Administrator   Aa123456!
"@

Import-Module ActiveDirectory

New-ADOrganizationalUnit -path "dc=$Domain, dc=$DomainEnding" -name $OrganizationalUnit -ProtectedFromAccidentalDeletion:$false
New-ADUser -Path "OU=$OrganizationalUnit,DC=$Domain,DC=$DomainEnding" -Name "CyberGuest" -AccountPassword (ConvertTo-SecureString "Should not be disabled!" -AsPlaintext -Force) -Description "Guest Account" -ChangePasswordAtLogon:$False -CannotChangePassword:$True -PasswordNeverExpires:$True -Enabled:$True
New-ADUser -Path "OU=$OrganizationalUnit,DC=$Domain,DC=$DomainEnding" -Name "Admin" -AccountPassword (ConvertTo-SecureString "bananas-12" -AsPlaintext -Force) -Description "Admin Account" -ChangePasswordAtLogon:$False -CannotChangePassword:$True -PasswordNeverExpires:$True -Enabled:$True
New-ADUser -Path "OU=$OrganizationalUnit,DC=$Domain,DC=$DomainEnding" -Name "Tech" -AccountPassword (ConvertTo-SecureString "Aa12345!@#" -AsPlaintext -Force) -Description "Tech Account" -ChangePasswordAtLogon:$False -CannotChangePassword:$True -PasswordNeverExpires:$True -Enabled:$True
Add-ADGroupMember 'Domain Admins' Admin
Add-ADGroupMember 'Domain Admins' Tech
Add-ADGroupMember 'Guests' CyberGuest


New-Item -Path "C:\triplec_files"  -ItemType Container
New-SmbShare -Path "C:\triplec_files" -Name "Admin" -ReadAccess everyone

$UserInfoToFile | Out-File -FilePath C:\triplec_files\Pass.txt -Encoding ASCII

Restart-Computer -Force