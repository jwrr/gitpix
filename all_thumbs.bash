
argc=$#
argv=("$@")

let last_arg=argc-1

echo "argc=$argc"
for i in $(seq 0 $last_arg)
do
    echo "argv[$i]="${argv[$i]}
done


if [ $argc -lt 3 ]
then
    echo "Format:  all_thumbs size folder filter"
    echo "Example: all_thumbs x64 ../xipix_content/beach *orig.jpg"
else
    size=${argv[0]}
    orig_path=${argv[1]}
    filter=${argv[2]}
    local_path=./content
    for img in ${orig_path}/$filter
    do
        thumb_full=`echo $img | sed s/.jpg/_${size}.jpg/`
        thumb_basename=$(basename "${thumb_full}")
        echo "convert $orig_path$img -thumbnail $size ${local_path}/${thumb_basename}"
        convert $img -thumbnail $size ${local_path}/${thumb_basename}
    done

fi

