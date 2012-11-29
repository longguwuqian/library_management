for i  in `find . -name "*.php"`; do iconv -f gbk -t utf-8 $i -o $i.new; done  
find . -name "*.new" | sed 's/\(.*\).new$/mv "&" "\1"/' | sh
