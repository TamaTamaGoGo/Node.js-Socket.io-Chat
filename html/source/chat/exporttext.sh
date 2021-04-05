
#!/bin/bash

oldsize=$(echo "scale=6; $(wc -c < $1) / 1000000"| bc)
while true
do
now=$(date "+%s.%N")

sh -c "echo -n '#' >> $1" &>/dev/null
byte=$(wc -c < $1)

sized=$(echo "scale=6; ${byte} / 1000000"| bc)
size=$(echo "scale=6; ${sized} - ${oldsize}" | bc)
oldsize=${sized}

ae="$(date "+%s.%N") - ${now}"
interval=$(bc -l <<<${ae})
ae="scale=2; 1 / ${interval}"
interval=$(bc -l <<<${ae})

ae="scale=2; ${size} * ${interval}"
secper=$(bc -l <<<${ae})

ae="1 / ${secper}"
ae=$(bc -l <<<${ae})
eta=$(echo "scale=2; ${ae} - ${sized}" | bc)

log="${sized}MB  ${size}MB/1time  ${interval}times/1sec ${secper}MB/1sec ETA:${eta}"
echo -en "\r${log}"
done
