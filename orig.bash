for from in *.jpg
do
    to=`echo $from | sed s/".jpg"/"_orig.jpg"/g`
    echo "mv $from $to"
    mv $from $to
done
