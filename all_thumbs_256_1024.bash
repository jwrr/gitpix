
argc=$#
argv=("$@")

path_filter='../xipix_content/*'
file_filter='*orig.jpg'

if [ $argc -ge 1]
then
  path_filter=${argv[0]}
fi

if [ $argc -ge 2]
then
  path_filter=${argv[1]}
fi

source all_thumbs.bash x256 "$path_filter" "$file_filter"
source all_thumbs.bash x1024 "$path_filter" "$file_filter"


