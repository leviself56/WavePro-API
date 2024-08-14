# WavePro REST API
## Php code for querying statistics from Ubiquiti WavePro

Server will need access to the switch in the same subnet/vlan.
The file `api.php` allows a remote server (like Zabbix) to query the switch and retrieve the datasets via HTTP POST.
This code can be further expanded to include POST, PATCH or PUT to manipulate the remote switch.

Current functions:
+ `get.interfaces`
+ `get.device`
+ `get.statistics`
+ `get.wireless.statistics`
+ `get.neighbors`




Example usage:

```POST http://localhost/WavePro/api.php```

```Content-Type: application/json```
```
{
  "ip": "10.15.100.170",
  "username": "ubnt",
  "password": "ubnt",
  "function": "get.device"
}
```


Sample Response:
```
[
  {
    "status": {
      "type": "wireless",
      "mtu": 1500,
      "enabled": true
    },
    "name": "60 GHz",
    "statistics": {
      "rxPPS": 3991,
      "txBytes": 854898824048,
      "txPPS": 1194,
      "rxRate": 31869618,
      "txPackets": 3166719394,
      "txRate": 4978032,
      "rxPackets": 11514474160,
      "rxBytes": 14598556443258
    },
    "id": "wlan0"
  },
  {
    "status": {
      "type": "wireless",
      "mtu": 1500,
      "enabled": true
    },
    "name": "5 GHz Backup",
    "statistics": {
      "rxPPS": 359,
      "txBytes": 535053153,
      "txPPS": 0,
      "rxRate": 173274,
      "txPackets": 2471608,
      "txRate": 0,
      "rxPackets": 768840179,
      "rxBytes": 54347427579
    },
    "id": "ath0"
  },
  {
    "status": {
      "type": "switch",
      "mtu": 1500,
      "enabled": true
    },
    "name": "Switch",
    "statistics": {
      "rxPPS": 1188,
      "txBytes": 14652104419988,
      "txPPS": 3981,
      "rxRate": 4766669,
      "txPackets": 11520691247,
      "txRate": 31876056,
      "rxPackets": 3169069529,
      "rxBytes": 806531543814
    },
    "id": "eth0"
  },
  {
    "status": {
      "media": "2.5GE",
      "plugged": true,
      "type": "port",
      "mtu": 1500,
      "enabled": true,
      "currentSpeed": "1000-full"
    },
    "name": "Ethernet Port 1",
    "statistics": {
      "rxPPS": 1188,
      "txBytes": 14652107520091,
      "txPPS": 3982,
      "rxRate": 4772948,
      "txPackets": 11520690294,
      "txRate": 32254910,
      "rxPackets": 3169069558,
      "rxBytes": 801342835713
    },
    "id": "eth0@0"
  },
  {
    "status": {
      "media": "2.5GE",
      "plugged": false,
      "type": "port",
      "mtu": 1500,
      "enabled": true,
      "currentSpeed": "10-half"
    },
    "name": "Ethernet Port 2",
    "statistics": {
      "rxPPS": 0,
      "txBytes": 0,
      "txPPS": 0,
      "rxRate": 0,
      "txPackets": 0,
      "txRate": 0,
      "rxPackets": 0,
      "rxBytes": 0
    },
    "id": "eth0@1"
  },
  {
    "status": {
      "media": "SFP-plus",
      "type": "ethernet",
      "mtu": 1500,
      "enabled": true,
      "plugged": false
    },
    "name": "SFP+ Port",
    "statistics": {
      "rxPPS": 0,
      "txBytes": 0,
      "txPPS": 0,
      "rxRate": 0,
      "txPackets": 0,
      "txRate": 0,
      "rxPackets": 0,
      "rxBytes": 0
    },
    "id": "eth1"
  },
  {
    "status": {
      "type": "bridge",
      "mtu": 1500,
      "enabled": true
    },
    "name": "Data",
    "statistics": {
      "rxPPS": 365,
      "txBytes": 4404146095,
      "txPPS": 1,
      "rxRate": 140454,
      "txPackets": 5705182,
      "txRate": 17402,
      "rxPackets": 776570297,
      "rxBytes": 37743670872
    },
    "id": "br0"
  }
]
```
