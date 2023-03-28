
.PHONY : test
test :
	php tune.php

.PHONY : ci
ci :
	composer exec tune.php

.PHONY : watch
watch :
	$(MAKE) test
	inotifywait -m -e close_write . | while read events; do $(MAKE) --no-print-directory; done
