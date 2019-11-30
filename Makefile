files := index.php shifter-cache-helper.php

.PHONY: archive clean

archive: clean
	zip shifter-cache-helper.zip $(files)

clean:
	rm -f shifter-cache-helper.zip
