for vid in *.mp4
do
    thumb=`echo $vid | sed s/".mp4"/"_x256.jpg"/g`
    echo "Convert $vid -thumbnail x256 $thumb"
    convert $vid [60] $thumb 
done

